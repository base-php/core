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

	public function replaceQuery($query)
	{
		$keys = array_keys($query);
		$key = $keys[0];

		$values = array_values($query);
		$value = $values[0];

		if (isset($_GET[$key])) {
			$_GET[$key] = $value;
		}

		$queryString = http_build_query($_GET);

		$this->url = $this->url . '?' . $queryString;

		return $this->url;
	}

	public function scheme()
	{
		$array = explode('://', $this->url);
		$scheme = $array[0];
		return $scheme;
	}

	public function withHost($host)
	{
		$this->url = str_replace($this->host, $host, $this->url);
		return $this->url;
	}

	public function withPath($path)
	{
		if ($this->path) {
			$this->url = str_replace($this->path, $path, $this->url);
		} else {
			$this->url = $this->scheme . '://' . $this->host . '/' . $path;

			if (! empty($_GET)) {
				$query = http_build_query($_GET);
				$this->url = $this->scheme . '://' . $this->host . '/' . $path . '?' . $query;
			}
		}

		return $this->url;
	}

	public function withQuery($query)
	{
		$key = array_keys($query);
		$key = $key[0];

		$value = array_values($query);
		$value = $value[0];
		
		$_GET[$key] = $value;

		$queryString = http_build_query($_GET);

		$this->url = $this->url . '?' . $queryString;

		return $this->url;
	}

	public function withScheme($scheme)
	{
		$this->url = str_replace(['http', 'https'], [$scheme, $scheme], $this->url);
		return $this->url;
	}
}
