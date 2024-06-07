<?php

class Cart
{
	public $cart;
	public $product;
	public $user;
	public $decimals;
	public $dec_point;
	public $thousands_sep;

	public function __construct($user)
	{
		$this->user = $user;

		$this->decimals = config('cart_decimals') ?? 2;
		$this->dec_point = config('cart_dec_point') ?? '.';
		$this->thousands_sep = config('cart_thousands_sep') ?? ',';

		$cart[$user] = [
			'products' => [],
			'conditions' => []
		];

		$this->save($cart);
	}

	public function add($data, $name = '', $price = '', $quantity = '', $extra = [])
	{
		/*
			'id' => 'string|required|unique'
			'name' => 'string|required'
			'price' => 'float|required'
			'quantity' => 'int|required'
			'extra' => 'nullable|iterable',
			'conditions' => 'nullable|iterable',
		*/

		if ($name != '' && $price != '' && $quantity != '') {
			$data = [
				'id' => $data,
				'name' => $name,
				'price' => $price,
				'quantity' => $quantity,
				'extra' => $extra,
			];
		}

		$cart = session('cart');

		if (! isset($data[0])) {
			$cart[$this->user]['products'][$data['id']] = $data;

		} else {
			foreach ($data as $item) {
				$cart[$this->user]['products'][$item['id']] = $item;
			}
		}

		$this->save($cart);
	}

	public function addItemCondition($product, $condition)
	{
		$cart = session('cart');
		$cart[$this->user]['products'][$product]['conditions'][] = $condition;
		$this->save($cart);
	}

	public function array()
	{
		return json_decode(json_encode($this->items()), true);
	}

	public function calculate($type, $wconditions = 1)
	{
		$return = 0;

		foreach ($this->items() as $item) {
			$price = $item->price;

			if ($wconditions) {
				if (isset($item->conditions)) {
					foreach ($item->conditions as $condition) {
						if (strpos($condition->value, '+') !== false) {
							if (strpos($condition->value, '%') !== false) {
								$value = str_replace(['%', '+'], ['', ''], $condition->value);
								$price = $price + ($price * $value / 100);
							} else {
								$value = str_replace('+', '', $condition->value);
								$price = $price + $value;
							}
						}

						if (strpos($condition->value, '-') !== false) {
							if (strpos($condition->value, '%') !== false) {
								$value = str_replace(['%', '-'], ['', ''], $condition->value);
								$price = $price - ($price * $value / 100);
							} else {
								$value = str_replace('-', '', $condition->value);
								$price = $price - $value;
							}
						}
					}
				}				
			}

			$return = $return + ($price * $item->quantity);
		}

		foreach ($this->conditions() as $condition) {
			if ($condition->target == $type) {
				if (strpos($condition->value, '+') !== false) {
					if (strpos($condition->value, '%') !== false) {
						$value = str_replace(['%', '+'], ['', ''], $condition->value);
						$return = $return + ($return * $value / 100);
					} else {
						$value = str_replace('+', '', $condition->value);
						$return = $return + $value;
					}
				}

				if (strpos($condition->value, '-') !== false) {
					if (strpos($condition->value, '%') !== false) {
						$value = str_replace(['%', '-'], ['', ''], $condition->value);
						$return = $return - ($return * $value / 100);
					} else {
						$value = str_replace('-', '', $condition->value);
						$return = $return - $value;
					}
				}
			}
		}

		return number_format($return, $this->decimals, $this->dec_point, $this->thousands_sep);
	}

	public function cart($user = '')
	{
		$user = $user ? $user : $this->user;
		$cart = session('cart');
		return $cart[$user];
	}

	public function clear()
	{
		$cart = session('cart');
		$cart[$this->user]['products'] = [];
		$this->save($cart);
	}

	public function clearItemConditions($product)
	{
		$cart = session('cart');
		$cart[$this->user]['products'][$product]['conditions'] = [];
		$this->save($cart);
	}

	public function clearConditions()
	{
		$cart = session('cart');
		$cart[$this->user]['conditions'] = [];
		$this->save($cart);
	}

	public function conditionsByType($type)
	{
		$return = [];

		foreach ($this->conditions() as $condition) {
			if ($condition->type == $type) {
				$return[] = $condition;
			}
		}

		return json_decode(json_encode($return));
	}

	public function conditions()
	{
		$cart = $this->cart();
		return json_decode(json_encode($cart['conditions']));
	}

	public function condition($data)
	{
		/*
			'name' => 'string|required'
			'type' => 'string|required'
			'target' => 'string|required'
			'value' => 'string|required'
		*/

		$cart = session('cart');

		if (! isset($data[0])) {
			$cart[$this->user]['conditions'][] = $data;
		} else {
			foreach ($data as $item) {
				$cart[$this->user]['conditions'][] = $item;
			}
		}

		$this->save($cart);
	}

	public function count()
	{
		$cart = session('cart');
		return count($cart[$this->user]['products']);
	}

	public function get($product)
	{
		$cart = $this->cart();
		return json_decode(json_encode($cart['products'][$product]));
	}

	public function items()
	{
		$cart = $this->cart();
		return json_decode(json_encode($cart['products']));
	}

	public function json()
	{
		return json_encode($this->items());
	}

	public function priceSum($product)
	{
		$product = $this->get($product);
		$priceSum = $product->price * $product->quantity;
		return number_format($priceSum, $this->decimals, $this->dec_point, $this->thousands_sep);
	}

	public function remove($product)
	{
		$cart = session('cart');
		unset($cart[$this->user]['products'][$product]);
		$this->save($cart);
	}

	public function removeCondition($condition)
	{
		$cart = session('cart');

		foreach ($this->conditions() as $item) {
			if ($condition != $item->name) {
				$cart[$this->user]['conditions'] = $item;
			}
		}

		$this->save($cart);
	}

	public function removeConditionsByType($type)
	{
		$cart = session('cart');

		foreach ($this->conditions() as $item) {
			if ($type != $item->type) {
				$cart[$this->user]['conditions'] = $item;
			}
		}

		$this->save($cart);
	}

	public function save($data)
	{
		include 'vendor/base-php/core/database/database.php';

		$schema = $capsule->getConnection('default')->getSchemaBuilder();

		if ($schema->hasTable('cart')) {
			DB::table('cart')->upsert($data, ['user_id'], $data);

		} else {
			session('cart', $data);
		}
	}

	public function subtotal()
	{
		return $this->calculate('subtotal');
	}

	public function subTotalWithoutConditions()
	{
		return $this->calculate('subtotal', 0);
	}

	public function total()
	{
		return $this->calculate('total');
	}

	public function totalQuantity()
	{
		$total = 0;

		foreach ($this->items() as $item) {
			$total = $total + $item->quantity;
		}

		return $total;
	}

	public function update($product, $data)
	{
		$cart = session('cart');

		foreach ($data as $key => $value) {
			if (is_array($value) && $value['relative'] == true) {
				$cart[$this->user]['products'][$product][$key] = $value['value'];

			} elseif ($key == 'quantity') {
				$cart[$this->user]['products'][$product][$key] = $cart[$this->user]['products'][$product][$key] + ($value);

			} else {
				$cart[$this->user]['products'][$product][$key] = $value;
			}
		}

		$this->save($cart);
	}
}
