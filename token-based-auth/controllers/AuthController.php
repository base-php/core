<?php

namespace App\Controllers;

use App\Models\Token;
use App\Models\User;

class AuthController extends Controller
{
	public function login()
	{
		$user = User::where('email', request('email'))
            ->where('password', encrypt(request('password')))
            ->first();

        if ($user) {
            $date_expire = carbon()->now()->timestamp;
            $hash = encrypt($date_expire);

            $token = Token::updateOrCreate(
                ['id_user' => $user->id],
                [
                    'token'       => $hash,
                    'date_create' => now('Y-m-d H:i:s'),
                    'date_update' => now('Y-m-d H:i:s'),
                    'date_expire' => $date_expire
                ]
            );

            return response()->json($token);
        }

        return response()->json('Invalid credentials', 401);
	}
}
