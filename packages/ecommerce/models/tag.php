<?php

namespace App\Models;

class Tag extends Model
{
	protected $table = 'tags';

	protected $primaryKey = 'id';

	protected $fillable = [
		'value',
		'date_create',
		'date_update'
	];

	public function taggable()
    {
        return $this->morphTo();
    }
}
