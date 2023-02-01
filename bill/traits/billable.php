<?php

namespace App\Models;

use App\Models\Customer;

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
}
