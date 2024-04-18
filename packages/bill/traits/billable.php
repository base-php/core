<?php

namespace App\Models;

use Dompdf\Dompdf;
use Dompdf\Options;

trait Billable
{
	// dompdf/dompdf

	public $customer;

	public function createOrGetCustomer()
	{
		$model_id = $this->id;
		$model = get_class($this);

		$data = [
			'model_id' => $model_id,
			'model' => $model
		];

		$this->customer = Customer::firstOrCreate($data);
	}

	public function checkout($items)
	{
		$this->createOrGetCustomer();

		$bill = Bill::create(['customer_id' => $this->customer->id]);

		$total = $tax = $discount = 0;

		foreach ($items as $item) {
			$item = is_array($item) ? (object) $item : $item;

			$item->tax = $item->tax ?? 0;
			$item->discount = $item->discount ?? 0;

			BillItem::create([
				'bill_id' => $bill->id,
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

	public function downloadBill($id, $config = [], $filename = 'bill.pdf')
	{
		if (! class_exists('Dompdf\Dompdf')) {
            throw new Exception('Please execute `composer require dompdf/dompdf`');
        }
        
		ob_start();

		$bill = Bill::find($id);

		$header = $config['header'] ?? config('name');
		$address = $config['address'] ?? config('address') ?? null;
		$city = $config['city'] ?? config('city') ?? null;
		$state = $config['state'] ?? config('state') ?? null;
		$country = $config['country'] ?? config('country') ?? null;
		$phone = $config['phone'] ?? config('phone') ?? null;
		$email = $config['email'] ?? config('email') ?? null;
		$url = $config['url'] ?? config('url') ?? null;

		view('bill:bill', compact('bill', 'header', 'address', 'city', 'state', 'country', 'phone', 'email', 'url'));

		$options = new Options();
        $options->setIsRemoteEnabled(true);

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml(utf8_encode(ob_get_clean()));
        $dompdf->render();
        $dompdf->stream($filename);
	}

	public function findBill($id)
	{
		$this->createOrGetCustomer();

		$bill = Bill::where('customer_id', $this->customer->id)
			->where('id', $id)
			->with('items')
			->first();

		return $bill;
	}

	public function bills()
	{
		$this->createOrGetCustomer();

		$bills = Bill::where('customer_id', $this->customer->id)
			->with('items')
			->get();

		return $bills;
	}
}
