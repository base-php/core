<?php

namespace App\Models;

use DB;
use Illuminate\Events\Dispatcher as EventsDispatcher;

trait Logs
{
    public function action($action)
    {
        $user_id = $this->user_id ?? null;
        $model_id = $this->model_id ?? null;
        $model = $this->model ?? null;

        $data = [
            'user_id' => $user_id,
            'model_id' => $model_id,
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
            $user_id = auth()->id ?? null;
            $model = get_class($item);

            $data = [
                'user_id' => $user_id,
                'model_id' => $item->id,
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
            session('basephp-old-updating', $item);
        });

        static::updated(function ($item) {
            $user_id = auth()->id ?? null;
            $model = get_class($item);

            $parameters['new'] = $item;
            $parameters['old'] = session('basephp-old-updating');

            $data = [
                'user_id' => $user_id,
                'model_id' => $item->id,
                'model' => $model,
                'action' => 'update',
                'parameters' => json_encode($parameters),
            ];

            DB::table('logs')
                ->insert($data);

            session()->delete('basephp-old-updating');
        });

        static::deleted(function ($item) {
            $user_id = auth()->id ?? null;
            $model = get_class($item);

            $data = [
                'user_id' => $user_id,
                'model_id' => $item->id,
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
        $this->user_id = $user->id ?? $user['id'] ?? $user ?? null;

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
        $this->model_id = $model->id;
        $this->model = get_class($model);

        return $this;
    }
}
