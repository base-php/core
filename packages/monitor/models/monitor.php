<?php

namespace App\Models;

class Monitor extends Model
{
	protected $table = 'monitor';

	protected $fillable = [
		'type',
		'content'
	];

	protected $casts = [
		'content' => 'object'
	];
}
