<?php

namespace App\Middleware;

class Monitor
{
	public function handle($request, $next)
	{
		if (in_array(auth()->email, config('monitor-auth'))) {
			return $next($request);
		} else {
			return abort(401);
		}
	}
}
