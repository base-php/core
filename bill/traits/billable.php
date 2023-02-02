<?php

namespace App\Models;

trait Billable
{
	public $customer;

	public function createOrGetCustomer()
	{
		$id_model = $this->id;
		$model = get_class($this);

		$data = [
			'id_model' => $id_model,
			'model' => $model
		];

		$$this->customer = Customer::firstOrCreate($data);
	}

	public function invoices()
	{
		$this->createOrGetCustomer();

		$bills = Bill::where('id_customer', $customer->id)
			->with('items')
			->get();

		return $bills;
	}
}
