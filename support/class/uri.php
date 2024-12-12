<?php

class Uri
{
	public function __construct($uri)
	{
		$this->of($uri);
	}

	public function host()
	{
		$array = explode('://', $this->url);
		$host = $array[1];

		if (strpos($array[1], '/')) {
			$array = explode('/', $array[1]);
			$host = $array[0];
		}

		$host = str_replace('www.', '', $host);

		return $host;
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

	public function path()
	{
		$path = null;
		$array = explode('/', $this->url);

		if (isset($array[2])) {
			$path = $array[2];

			if (strpos($path, '?')) {
				$array = explode('?', $path);
				$path = $array[0];
			}
		}

		return $path;
	}

	public function query()
	{
		return new class {
			public function all()
			{
				return (object) $_GET;
			}

			public function has($key)
			{
				if (isset($_GET[$key])) {
					return true;
				}

				return false;
			}
		};
	}

	public function scheme()
	{
		$array = explode('://', $this->url);
		$scheme = $array[0];
		return $scheme;
	}
}
