<?php

class Cart
{
	public $cart;
	public $product;
	public $user;

	public function __construct($user)
	{
		$this->user = $user;

		$cart[$user] = [
			'products' => [],
			'conditions' => []
		];
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

		$cart = $this->cart();

		if ($name != '' && $price != '' && $quantity != '') {
			$data = [
				'id' => $data,
				'name' => $name,
				'price' => $price,
				'quantity' => $quantity,
				'extra' => $extra,
			];
		}

		if (count($data) == count($data, COUNT_RECURSIVE)) {
			$cart['products'][$data['id']] = $data;
		} else {
			foreach ($data as $item) {
				$cart['products'][$item['id']] = $item;
			}
		}

		session('cart', $cart);
	}

	public function addItemCondition($product, $condition)
	{
		$cart = $this->cart();
		$cart['products'][$product]['conditions'][] = $condition;
		session('cart', $cart);
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
				if ($item->conditions) {
					foreach ($item->conditions as $condition) {
						if (strpos($condition->value, '+') !== false) {
							if (strpos($condition->value, '%') !== false) {
								$value = str_replace(['%', '+'], ['', ''], $condition->value);
								$price = $price + ($price * 15 / 100);
							} else {
								$value = str_replace('+', '', $condition->value);
								$price = $price + $value;
							}
						}

						if (strpos($condition->value, '-') !== false) {
							if (strpos($condition->value, '%') !== false) {
								$value = str_replace(['%', '-'], ['', ''], $condition->value);
								$price = $price - ($price * 15 / 100);
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
						$return = $return + ($return * 15 / 100);
					} else {
						$value = str_replace('+', '', $condition->value);
						$return = $return + $value;
					}
				}

				if (strpos($condition->value, '-') !== false) {
					if (strpos($condition->value, '%') !== false) {
						$value = str_replace(['%', '-'], ['', ''], $condition->value);
						$return = $return - ($return * 15 / 100);
					} else {
						$value = str_replace('-', '', $condition->value);
						$return = $return - $value;
					}
				}
			}
		}

		return $return;
	}

	public function cart($user = '')
	{
		$user = $user ?? $this->user;
		$cart = session('cart');
		return $cart[$user];
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

		$cart = $this->cart();

		if (count($data) == count($data, COUNT_RECURSIVE)) {
			$cart['conditions'][$data['id']] = $data;
		} else {
			foreach ($data as $item) {
				$cart['conditions'][$item['id']] = $item;
			}
		}

		session('cart', $cart);
	}

	public function count()
	{
		return count($this->items());
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
		return $priceSum;
	}

	public function remove($product)
	{
		$cart = $this->cart();
		unset($cart['products'][$product]);
	}

	public function subtotal()
	{
		return calculate('subtotal');
	}

	public function subTotalWithoutConditions()
	{
		return calculate('subtotal', 0);
	}

	public function total()
	{
		return calculate('total');
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
		$cart = $this->cart();

		foreach ($data as $key => $value) {
			if (is_array($value) && $value['relative'] == false) {
				$cart['products'][$product][$key] = $value;
			}

			if ($key == 'quantity') {
				$cart['products'][$product][$key] = $cart['products'][$product][$key] + ($value);
			}
		}

		session('cart', $cart);
	}
}
