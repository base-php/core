<?php

class CashConverter
{
	public function __construct()
	{
		$config = require 'app/config.php';
		$this->key = $config['exchange-rate-key'];
	}

	public function rates($currency)
	{
		$http = http()->get('https://v6.exchangerate-api.com/v6/' . $this->key . '/latest/' . $currency);
		$body = $http->body();
		$json = json($body);
		return $json['conversion_rates'];
	}
}
