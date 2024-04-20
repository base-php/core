<?php

class Cart
{
	public $user;

	public function __construct($user)
	{
		$this->user = $user;

		$cart[$user] = [
			'products' => [],
			'conditions' => []
		];
	}

	public function add($data)
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

		if (count($data) == count($data, COUNT_RECURSIVE)) {
			$cart['products'][$data['id']] = $data;
		} else {
			foreach ($data as $item) {
				$cart['products'][$item['id']] = $item;
			}
		}

		session('cart', $cart);
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
		return json_decode(json_encode($cart['conditions']), true);
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

	public function items()
	{
		$cart = $this->cart();
		return json_decode(json_encode($cart['products']), true);
	}

	public function remove($product)
	{
		$cart = $this->cart();
		unset($cart['products'][$product]);
	}

	public function total()
	{
		$total = 0;

		foreach ($this->items() as $item) {
			$price = $item->price;

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

			$total = $total + ($price * $item->quantity);
		}

		foreach ($this->conditions as $condition) {
			if ($condition->target == 'total') {
				if (strpos($condition->value, '+') !== false) {
					if (strpos($condition->value, '%') !== false) {
						$value = str_replace(['%', '+'], ['', ''], $condition->value);
						$total = $total + ($total * 15 / 100);
					} else {
						$value = str_replace('+', '', $condition->value);
						$total = $total + $value;
					}
				}

				if (strpos($condition->value, '-') !== false) {
					if (strpos($condition->value, '%') !== false) {
						$value = str_replace(['%', '-'], ['', ''], $condition->value);
						$total = $total - ($total * 15 / 100);
					} else {
						$value = str_replace('-', '', $condition->value);
						$total = $total - $value;
					}
				}
			}
		}

		return $total;
	}

	public function update($product, $data)
	{
		$cart = $this->cart();

		foreach ($data as $key => $value) {
			$cart['products'][$product][$key] = $value;
		}
	}
}
