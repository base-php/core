<?php

namespace App\Models;

class Bill extends Model
{
	protected $table = 'bills';

	protected $primaryKey = 'id';

	protected $fillable = [
		'customer_id',
		'discount',
		'tax',
		'total'
	];

	public function customer()
	{
		return $this->belongsTo(Customer::class, 'customer_id');
	}

	public function items()
	{
		return $this->hasMany(BillItem::class, 'bill_id');
	}

	public function getSubtotalAttribute()
	{
		return $this->total - $this->tax;
	}
}
