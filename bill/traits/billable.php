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

		$this->customer = Customer::firstOrCreate($data);
	}

	public function checkout($items)
	{
		$this->createOrGetCustomer();

		$bill = Bill::create(['id_customer' => $this->customer->id]);

		$total = $tax = $discount = 0;

		foreach ($items as $item) {
			$item = is_array($item) ? (object) $item : $item;

			BillItem::create([
				'id_bill' => $bill->id,
				'description' => $item->description,
				'quantity' => $item->quantity,
				'price' => $item->price,
				'tax' => $item->tax,
				'discount' => $item->discount,
			]);

			$total += $item->price;
			$tax += $item->tax;
			$discount += $item->discount;
		}

		$bill->update([
			'total' => $total,
			'tax' => $tax,
			'discount' => $discount,
		]);

		return $bill;
	}

	public function findBill($id)
	{
		$this->createOrGetCustomer();

		$bill = Bill::where('id_customer', $this->customer->id)
			->where('id', $id)
			->with('items')
			->first();

		return $bill;
	}

	public function bills()
	{
		$this->createOrGetCustomer();

		$bills = Bill::where('id_customer', $this->customer->id)
			->with('items')
			->get();

		return $bills;
	}
}
