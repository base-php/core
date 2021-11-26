<?php

include 'texts.php';

class Console
{
	public static function run()
	{
		include 'analyse.php';
		include 'empty.php';
		include 'files.php';
		include 'migrate.php';
		include 'server.php';
		include 'tests.php';
	}
}