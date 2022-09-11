<?php

namespace Tests;

use DB;
use PHPUnit\Framework\TestCase;

class Test extends TestCase
{
	public function assertDatabaseHas($table, $data)
	{
		include 'database.php';

		$db = DB::table($table)
			->where($data)
			->get();

		if ($db->count()) {
			return $this->assertTrue(true);
		}

		return $this->fail('Valor no existe en base de datos');
	}

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