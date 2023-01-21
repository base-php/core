<?php

namespace App\Middleware;

use App\Models\Token;
use App\Models\User;

class TokenBasedAuth
{
    public function handle($request, $next)
    {
        $now = time();

        $token = Token::where('token', request('token'))
            ->where('date_expire', '>=', $now)
            ->first();

        if (! $token) {
            return abort(401);
        }

        if ($token->model == 'App\Models\User') {
            $user = User::find($token->id_model);
            session('id', $user->id);
        }

        return $next($request);
    }
}
