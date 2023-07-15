<?php

namespace App\Models;

class Language extends Model
{
	protected $table = 'language';

    protected $primaryKey = 'id';

    protected $fillable = [
        'language',
        'key',
        'value',
        'date_create',
        'date_update'
    ];
}
