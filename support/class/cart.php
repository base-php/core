<?php

class Cart
{
	public $user;

	public function __construct($user)
	{
		$this->user = $user;

		$cart[$user] = [
			'products' => []
		];
	}

	public function add($data)
	{
		$cart = $this->cart();
		$cart['products'][] = $data;
		session('cart', $cart);
	}

	public function cart($user = '')
	{
		$user = $user ?? $this->user;
		$cart = session('cart');
		return $cart[$user];
	}

	public function remove($product)
	{
		$cart = $this->cart();
		unset($cart['products'][$product]);
	}

	public function update($product, $data)
	{
		$cart = $this->cart();

		foreach ($data as $key => $value) {
			$cart['products'][$product][$key] = $value;
		}
	}
}
