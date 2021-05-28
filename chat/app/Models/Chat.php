<?php

namespace App\Models;

class Chat extends Model
{
    /**
     * The table associated with model.
     *
     * $var string
     */
    protected $table = 'chats';

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
    protected $fillable = ['id_sender', 'id_addresse', 'date', 'read', 'receive', 'content', 'timestamp', 'deleted'];

    /**
     * Get the format date.
     *
     * @param  string  $value
     * @return string
     */
    public function getDateAttribute($value)
    {
        $date = (date('d/m/Y', $value) == date('d/m/Y')) ? date('h:ia', $value) : date('d/m/Y h:ia', $value);
        return $date;
    }
}
