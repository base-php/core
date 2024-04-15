<?php

namespace App\Models;

class Currency extends Model
{
	protected $table = 'currencies';

	protected $primaryKey = 'id';

	protected $fillable = [
		'code',
		'name',
		'exchange_rate',
		'format',
		'decimal_point',
		'thousand_point',
		'decimal_places',
		'enabled',
		'default',
		'date_create',
		'date_update'
	];
}
