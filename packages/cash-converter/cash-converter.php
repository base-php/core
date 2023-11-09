<?php

class CashConverter
{
	public function __construct()
	{
		$config = require 'app/config.php';
		$this->key = $config['exchange-rate-key'];
	}

	public function convert($from, $to, $amount)
	{
		$json = $this->request($from);
		return $amount * $json['conversion_rates'][$to];
	}

	public function rate($from, $to)
	{
		$json = $this->request($from);
		return $json['conversion_rates'][$to];
	}

	public function rates($currency)
	{
		$json = $this->request($currency);
		return $json['conversion_rates'];
	}

	public function request($currency)
	{
		$http = http()->get('https://v6.exchangerate-api.com/v6/' . $this->key . '/latest/' . $currency);
		$body = $http->body();
		$json = json($body);
		return $json;
	}
}
