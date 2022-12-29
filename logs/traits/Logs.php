<?php

namespace App\Models;

use DB;
use Illuminate\Events\Dispatcher as EventsDispatcher;

trait Logs
{
	protected static function booted()
    {
        static::boot();
        static::setEventDispatcher(new EventsDispatcher());

        static::created(function ($item) {
        	$id_user = auth()->id ?? null;
        	$model = get_class($item);

        	$data = [
        		'id_user' => $id_user,
        		'id_model' => $item->id,
        		'model' => $model,
        		'action' => 'create',
        		'parameters' => $item
        	];

        	DB::table('logs')
        		->insert($data);
        });

        static::updating(function ($item) {
        	$class = get_class($item);
        	$item = (new $class)->find($item->id);
        	$_SESSION['basephp-old-updating'] = $item;
        });

        static::updated(function ($item) {
        	$id_user = auth()->id ?? null;
        	$model = get_class($item);

        	$parameters['new'] = $item;
        	$parameters['old'] = $_SESSION['basephp-old-updating'];

        	$data = [
        		'id_user' => $id_user,
        		'id_model' => $item->id,
        		'model' => $model,
        		'action' => 'update',
        		'parameters' => json_encode($parameters)
        	];

        	DB::table('logs')
        		->insert($data);

        	unset($_SESSION['basephp-old-updating']);
        });

        static::deleted(function ($item) {
        	$id_user = auth()->id ?? null;
        	$model = get_class($item);

        	$data = [
        		'id_user' => $id_user,
        		'id_model' => $item->id,
        		'model' => $model,
        		'action' => 'delete',
        		'parameters' => $item
        	];

        	DB::table('logs')
        		->insert($data);
        });
    }
}
