<?php

namespace App\Models;

class Order extends Model
{
	protected $table = 'orders';

	protected $primaryKey = 'id';

	protected $fillable = [
		'order_id',
		'country_id',
		'title',
		'name',
		'city',
		'state',
		'zip_code',
		'email',
		'phone',
		'meta',
		'date_create',
		'date_update'
	];

	protected $casts = [
		'meta' => 'array'
	];

	public function order()
    {
        return $this->belongsTo('App\Models\Order');
    }

    public function country()
    {
        return $this->belongsTo('App\Models\Country');
    }
}
