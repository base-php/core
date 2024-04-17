<?php

namespace App\Models;

class Product extends Model
{
	protected $table = 'products';

	protected $primaryKey = 'id';

	protected $fillable = [
		'product_type_id',
		'status',
		'attribute_data',
		'brand',
		'date_create',
		'date_update'
	];

	public function productType()
    {
        return $this->belongsTo('App\Models\ProductType');
    }

    public function images()
    {
        return $this->where('model', get_class($this))
        	->where('model_id', $this->id);
    }

    public function brand()
    {
        return $this->belongsTo('App\Models\Brand');
    }
}
