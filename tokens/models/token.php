<?php

namespace App\Models;

class Token extends Model
{
    protected $table = 'tokens';

    protected $fillable = [
        'name',
        'model',
        'id_model',
        'token',
        'date_expire'
    ];
}
