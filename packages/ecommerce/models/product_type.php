<?php

namespace App\Models;

class ProductType extends Model
{
	protected $table = 'product_types';

	protected $primaryKey = 'id';

	protected $fillable = [
		'name',
		'date_create',
		'date_update'
	];

	public function products()
    {
        return $this->hasMany('App\Models\Product');
    }
}
