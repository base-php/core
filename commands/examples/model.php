<?php

namespace App\Models;

class ModelName extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected string $table = '';

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected string $primaryKey = '';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected array $fillable = [];
}
