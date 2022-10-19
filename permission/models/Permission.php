<?php

namespace App\Models;

class Role
{
	/**
     * The table associated with model.
     *
     * $var string
     */
	protected $table = 'permissions';

	/**
     * The primary key of the model.
     *
     * $var string
     */
    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * $var array
     */
    protected $fillable = ['name', 'description', 'date_create', 'date_update'];
}
