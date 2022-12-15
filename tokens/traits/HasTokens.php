<?php

namespace App\Models;

use App\Models\Token;

trait HasTokens
{
	public function createToken($name)
	{
		$tokenable_type = get_class($this);
		$tokenable_id = $this->id;

		$time = time();

		$string = "$time-$name-$tokenable_type-$tokenable_id";
		$hash = hash('sha256', $string);

		$seconds = config('token_expire') ?? 86400;

		$date_expire = carbon()
			->now()
			->addSeconds($seconds)
			->timestamp;

		$token = Token::create([
			'tokenable_type' => get_class($this),
			'tokenable_id' => $this->id,
			'name' => $name,
			'token' => $hash,
			'date_expire' => $date_expire
		]);

		return $token;
	}

	public function tokens()
	{
		$tokenable_type = get_class($this);
		$tokenable_id = $this->id;

		$tokens = Token::where('tokenable_type', $tokenable_type)
			->where('tokenable_id')
			->get();

		return $tokens;
	}
}
