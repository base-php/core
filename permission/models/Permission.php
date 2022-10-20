<?php

namespace App\Models;

class Role
{
	protected $table = 'permissions';

    protected $primaryKey = 'id';
    
    protected $fillable = ['name', 'description', 'date_create', 'date_update'];
}
