<?php

namespace App\Middleware;

class Can
{
    public function handle($request, $next, $permission)
    {
        if (! can($permission)) {
            return abort(401);
        }

        return $next($request);
    }
}
