<?php

namespace App\Models;

class Address extends Model
{
	protected $table = 'address';

	protected $primaryKey = 'id';

	protected $fillable = [
		'customer_id',
		'country_id',
		'title',
		'name',
		'city',
		'state',
		'postcode',
		'shipping_default',
		'billing_default',
		'date_create',
		'date_update',
	];

	protected $casts = [
        'billing_default' => 'boolean',
        'meta' => 'array',
        'shipping_default' => 'boolean',
    ];

    public function country()
    {
        return $this->belongsTo('App\Models\Country');
    }

    public function customer()
    {
        return $this->belongsTo('App\Models\Customer');
    }
}
