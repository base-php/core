<?php

namespace App\Middleware;

class Monitor
{
	public function handle($request, $next)
	{
		if (config('monitor-auth')) {
			if (in_array(auth()->email, config('monitor-auth'))) {
				return $next($request);
			} else {
				return abort(401);
			}			
		}

		return $next($request);
	}
}
