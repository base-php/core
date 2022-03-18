<?php

use Omnipay\Omnipay;

class Payments
{
	// league/omnipay
	
	public $gateway;

	public $redirect;

	public $response;

	public $success;

	public function gateway($gateway)
	{
		if ($gateway == 'mercado-pago') {

		}

		if ($gateway == 'paypal') {
			
		}

		if ($gateway == 'payu') {
			
		}

		if ($gateway == 'stripe') {
			$this->gateway = Omnipay::create('Stripe');
			$this->gateway->setApiKey(config('stripe'));
		}

		return $this;
	}

	public function purchase($data)
	{
		$this->response = $this->gateway->purchase($data)->send();

		if ($this->response->isRedirect()) {
			$this->redirect = true;
		}

		if ($this->response->isSuccessful()) {
			$this->success = true;
		}

		return $this;
	}

	public function redirect()
	{
		return $this->response->redirect();
	}

	public function success()
	{
		return $this->response;
	}
}
