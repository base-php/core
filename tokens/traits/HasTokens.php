<?php

namespace App\Models;

use App\Models\Token;

trait HasTokens
{
	public function createToken($name)
	{
		$model = get_class($this);
		$id_model = $this->id;

		$time = time();

		$string = "$time-$name-$model-$id_model";
		$hash = hash('sha256', $string);

		$seconds = config('token_expire') ?? 86400;

		$date_expire = carbon()
			->now()
			->addSeconds($seconds)
			->timestamp;

		$token = Token::create([
			'model' => get_class($this),
			'id_model' => $this->id,
			'name' => $name,
			'token' => $hash,
			'date_expire' => $date_expire
		]);

		return $token;
	}

	public function tokens()
	{
		$model = get_class($this);
		$id_model = $this->id;

		$tokens = Token::where('model', $model)
			->where('id_model', $id_model)
			->get();

		return $tokens;
	}
}
