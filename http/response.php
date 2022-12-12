<?php

class Response
{
	public function json($iterable, $status_code = 200)
	{
		http_response_code($status_code);
		header('Content-Type: application/json; charset=utf-8');
		echo json_encode($iterable);
	}
}
