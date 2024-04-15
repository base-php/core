<?php

namespace App\Models;

class Customer extends Model
{
	protected $table = 'customers';

	protected $primaryKey = 'id';

	protected $fillable = [
		'title',
		'name',
		'vat',
		'meta',
		'date_create',
		'date_update'
	];

	protected $casts = [
		'meta' => 'array'
	];

	public function addresses()
    {
        return $this->hasMany('App\Models\Address');
    }

    public function orders()
    {
        return $this->hasMany('App\Models\Order');
    }
}
