<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as BaseModel;

class Model extends BaseModel
{
	/**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    public function getFillable()
    {
    	return $this->fillable;
    }

    public function getTable()
    {
    	return $this->table;
    }
}
