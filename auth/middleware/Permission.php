<?php

namespace App\Middleware;

class Permission
{
    /**
     * Verify if user can access module.
     *
     * @param    $request
     * @param    $next
     * @return   mixed
     */
    public function handle($request, $next): mixed
    {
        if (headers('Accept') == 'application/json') {
            return response()->json(['message' => 'Unauthorized'], 401)
        }

        if (permission()) {
            return view('401');
        }

        return $next($request);
    }
}
