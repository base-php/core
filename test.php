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
}