<?php

namespace App\Models;

class OrderItem extends Model
{
	protected $table = 'order_items';

	protected $primaryKey = 'id';

	protected $fillable = [
		'order_id',
		'type',
		'description',
		'price',
		'quantity',
		'subtotal',
		'discount',
		'tax',
		'total',
		'notes',
		'meta',
		'date_create',
		'date_update'
	];

	protected $casts = [
		'quantity' => 'integer',
		'meta' => 'array'
	];

	public function order()
    {
        return $this->belongsTo('App\Models\Order');
    }

    public function currency()
    {
        return $this->hasOneThrough(
            'App\Models\Currency',
            'App\Models\Order',
            'id',
            'code',
            'order_id',
            'currency_code'
        );
    }
}
