<?php

namespace App\Models;

class ModelStatus extends Model
{
	protected $table = 'model_status';

	protected $primaryKey = 'id';

	protected $fillable = [
		'name',
		'reason',
		'model',
		'model_id'
	];
}
