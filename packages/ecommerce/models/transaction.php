<?php

namespace App\Models;

class Transaction extends Model
{
	protected $table = 'transactions';

	protected $primaryKey = 'id';

	protected $fillable = [
		'order_id',
		'success',
		'refund',
		'driver',
		'amount',
		'reference',
		'status',
		'notes',
		'card_type',
		'last_four',
		'meta',
		'date_create',
		'date_update'
	];

	protected $casts = [
		'refund' => 'bool',
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
            'currency'
        );
    }
}
