<?php

class Response
{
	public function cookies($cookies, $time = 0)
	{
		$time = ($time != 0) ? time() + $time : 0;

		foreach ($cookies as $key => $value) {
			setcookie($key, $value, $time);
		}

		return $this;
	}

	public function headers($headers)
	{
		foreach ($headers as $key => $value) {
			header($key . ': ' . $value);
		}

		return $this;
	}

	public function json($iterable, $status_code = 200)
	{
		http_response_code($status_code);
		
		header('Content-Type: application/json; charset=utf-8');

		$iterable = is_iterable($iterable) ? $iterable : (array) $iterrable;
		return json_encode($iterable);
	}
}
