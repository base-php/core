<?php

class Uri
{
	public function __construct($uri)
	{
		$this->of($uri);
	}

	public function of($uri = '')
	{
		if ($uri) {
			if (! filter_var($uri, FILTER_VALIDATE_URL)) {
				throw new Exception('It is not a valid URL');
			}

			$this->uri = $uri;
		} else {
			$schema = $_SERVER['REQUEST_SCHEME'] ?? 'http';
			$host = $_SERVER['REQUEST_HOST'];
			$uri = $_SERVER['REQUEST_URI'];

			$this->uri = $schema . '://' . $host . $uri;
		}
	}

	public function scheme()
	{
		$array = explode('://', $this->url);
		$scheme = $array[0];
		return $scheme;
	}
}
