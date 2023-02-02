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
		'total',
		'note',
		'status'
	];

	public function items()
	{
		return $this->hasMany(BillItem::class, 'id_bill');
	}
}
