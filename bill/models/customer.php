<?php

namespace App\Models;

class Customer extends Model
{
	protected $table = 'customers';

	protected $fillable = [
		'id_model',
		'model'
	];
}
