<?php

namespace App\Models;

class Token extends Model
{
	protected $table = 'tokens';

	protected $fillable = ['tokenable_type', 'tokenable_id', 'name', 'token', 'date_expire'];
}
