<?php

namespace App\Middleware;

class MiddlewareName
{
    /**
     * Handle an incoming request.
     *
     * @param  $request
     * @param  $next
     * @return mixed
     */
    public function handle($request, $next)
    {
        if () {
            return redirect();
        }

        return $next($request);
    }
}
