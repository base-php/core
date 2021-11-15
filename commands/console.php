<?php

include 'texts.php';

class Console
{
	public static function run()
	{
		include 'empty.php';
		include 'files.php';
		include 'metrics.php';		
		include 'migrate.php';
		include 'server.php';
		include 'tests.php';
	}
}