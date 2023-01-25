<?php

namespace App\Models;

use DB;
use Illuminate\Events\Dispatcher as EventsDispatcher;

trait Logs
{
    public function action($action)
    {
        $id_user = $this->id_user ?? null;
        $id_model = $this->id_model ?? null;
        $model = $this->model ?? null;

        $data = [
            'id_user' => $id_user,
            'id_model' => $id_model,
            'model' => $model,
            'action' => $action,
        ];

        DB::table('logs')
            ->insert($data);
    }

    public function all()
    {
        $logs = DB::table('logs')->get();

        return $logs;
    }

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
                'parameters' => $item,
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
                'parameters' => json_encode($parameters),
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
                'parameters' => $item,
            ];

            DB::table('logs')
                ->insert($data);
        });
    }

    public function by($user)
    {
        $this->id_user = $user->id ?? $user['id'] ?? $user ?? null;

        return $this;
    }

    public function changes()
    {
        $log = DB::table('logs')
            ->where('id', $this->id)
            ->first();

        if (isset($log->action) && $log->action == 'update') {
            return json_decode($log->parameters);
        }

        return null;
    }

    public function on($model)
    {
        $this->id_model = $model->id;
        $this->model = get_class($model);

        return $this;
    }
}
