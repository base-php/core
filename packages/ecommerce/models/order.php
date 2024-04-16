<?php

namespace App\Models;

class Order extends Model
{
	protected $table = 'orders';

	protected $primaryKey = 'id';

	protected $fillable = [
		'status',
		'reference',
		'customer_id',
		'subtotal',
		'discount',
		'shipping',
		'tax',
		'total',
		'notes',
		'currency',
		'meta',
		'date_create',
		'date_update'
	];

	protected $casts = [
		'meta' => 'array'
	];

	public function items()
    {
        return $this->hasMany('App\Models\OrderItem');
    }

    public function currency()
    {
        return $this->belongsTo('App\Models\Currency', 'currency', 'code');
    }

    public function addresses()
    {
        return $this->hasMany('App\Models\OrderAddress', 'order_id');
    }

    public function transactions()
    {
        return $this->hasMany('App\Models\Transaction');
    }

    public function customer()
    {
        return $this->belongsTo('App\Mdoels\Customer');
    }
}
