<?php

class Response
{
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
		return json_encode($iterable);
	}
}
