<?php

namespace App\Models;

class BillItem extends Model
{
	protected $table = 'bills_items';

	protected $primaryKey = 'id';

	protected $fillable = [
		'bill_id',
		'description',
		'quantity',
		'price'
	];

	public function bill()
	{
		return $this->belongsTo(Bill::class, 'bill_id');
	}
}
