<?php

namespace App\Models;

class Bill extends Model
{
	protected $table = 'bills';

	protected $primaryKey = 'id';

	protected $fillable = [
		'id_customer',
		'discount',
		'tax',
		'total'
	];

	public function customer()
	{
		return $this->belongsTo(Customer::class, 'id_customer');
	}

	public function items()
	{
		return $this->hasMany(BillItem::class, 'id_bill');
	}

	public function getSubtotalAttribute()
	{
		return $this->total - $this->tax;
	}
}
