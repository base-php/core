<?php

namespace App\Models;

class Country extends Model
{
	protected $table = 'countries';

	protected $primaryKey = 'id';

	protected $fillable = [
		'name',
		'iso3',
		'iso2',
		'phonecode',
		'capital',
		'currency',
		'date_create',
		'date_update'
	];

    public function states()
    {
        return $this->belongsTo('App\Models\State');
    }
}
