<?php

namespace App\Models;

class Token extends Model
{
    protected $table = 'tokens';

    protected $fillable = [
        'name',
        'model',
        'model_id',
        'token',
        'date_expire'
    ];
}
