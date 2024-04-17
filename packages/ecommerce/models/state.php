<?php

namespace App\Models;

class State extends Model
{
	protected $table = 'states';

	protected $primaryKey = 'id';

	protected $fillable = [
		'countr_id',
		'name',
		'code',
		'date_create',
		'date_update'
	];

	public function country()
    {
        return $this->belongsTo('App\Models\Country');
    }
}
