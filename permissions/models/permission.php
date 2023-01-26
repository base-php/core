<?php

namespace App\Models;

class Permission extends Model
{
    protected $table = 'permissions';

    protected $primaryKey = 'id';

    protected $fillable = ['name', 'description', 'date_create', 'date_update'];
}
