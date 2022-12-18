<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model as BaseModel;

class Model extends BaseModel
{
    public $timestamps = false;

    const DELETED_AT = 'date_delete';

    public function getFillable()
    {
    	return $this->fillable;
    }

    public function getTable()
    {
    	return $this->table;
    }
}
