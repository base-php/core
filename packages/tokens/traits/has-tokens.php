<?php

namespace App\Models;

trait HasTokens
{
    public function createToken($name)
    {
        $model = get_class($this);
        $model_id = $this->id;

        $time = time();

        $string = "$time-$name-$model-$model_id";
        $hash = hash('sha256', $string);

        $seconds = config('token_expire') ?? 86400;

        $date_expire = carbon()
            ->now()
            ->addSeconds($seconds)
            ->timestamp;

        $token = Token::create([
            'model' => get_class($this),
            'model_id' => $this->id,
            'name' => $name,
            'token' => $hash,
            'date_expire' => $date_expire,
        ]);

        return $token;
    }

    public function tokens()
    {
        $model = get_class($this);
        $model_id = $this->id;

        $tokens = Token::where('model', $model)
            ->where('model_id', $model_id)
            ->get();

        return $tokens;
    }
}
