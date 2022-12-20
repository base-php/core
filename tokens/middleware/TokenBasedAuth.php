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

        if (!$token) {
            return abort(401);
        }

        if ($token->tokenable_type == 'App\Models\User') {
            $user = User::find($token->tokenable_id);
            session('id', $user->id);
        }

        return $next($request);
    }
}
