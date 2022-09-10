<?php

namespace Tests;

use PHPUnit\Framework\TestCase;

class Test extends TestCase
{
	public function get($route)
	{
		$url = "localhost:8080/$route";
		$request = http()->get($url);
		return $request;
	}

	public function post($route, $data)
	{
		$url = "localhost:8080/$route";
		$request = http()->post($url, $data);
		return $request;
	}
}