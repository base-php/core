<?php

namespace App\Models;

class Monitor
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
