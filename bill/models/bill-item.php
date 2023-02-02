<?php

namespace App\Models;

class BillItem extends Model
{
	protected $table = 'bills_items';

	protected $primaryKey = 'id';

	protected $fillable = [
		'id_bill',
		'description',
		'quantity',
		'price'
	];

	public function bill()
	{
		return $this->belongsTo(Bill::class, 'id_bill');
	}
}
