<?php

if (isset($_SERVER['argv'][1]) && strpos($_SERVER['argv'][1], 'create-database') === 0) {
	include 'vendor/nisadelgado/framework/database.php';

	$driver		= config('database', 'driver');
	$host 		= config('database', 'host');
	$username	= config('database', 'username');
	$password	= config('database', 'password');
	$database	= (config('database', 'driver') == 'sqlite') ? config('database', 'database') . '.sqlite' : config('database', 'database');

	if ($database != '') {
		if ($driver == 'sqlite') {
			$fopen = fopen($database, 'w+');
			fclose($fopen);
		} else {
			$pdo = new PDO("$driver:host=$host;", $username, $password);
			$pdo->exec('CREATE DATABASE IF NOT EXISTS ' . $database);
		}

		echo success("Database '$database' created successfully.");
		line_break();
	} else {
		echo danger("You must set a name for the database in the config.");
		line_break();
	}
}


if (isset($_SERVER['argv'][1]) && strpos($_SERVER['argv'][1], 'run-sql') === 0) {
	include 'vendor/nisadelgado/framework/database.php';

	$case = strpos($_SERVER['argv'][1], '=');

	if ($case) {
		$file = str_replace('run-sql=', '', $_SERVER['argv'][1]);

		if ($file == '') {
			echo danger('You have not specified the name of the file to run.');
			exit;
		}

		if (file_exists('database/' . $file)) {
			$sql = file_get_contents('database/' . $file);
			$sql = trim($sql);

			if (config('database', 'driver') == 'sqlite') {
				$sql = str_replace('AUTO_INCREMENT', 'AUTOINCREMENT', $sql);
			}

			if (strlen($sql)) {
				try {
					foreach (explode(';', $sql) as $sentence) {
						if (strlen($sentence)) {
							Illuminate\Database\Capsule\Manager::select($sentence);
						}
					}
						
					echo success($file . ' is ok.');
					line_break();
				}
				catch (PDOException $e) {
					echo danger($file . ' has an error: ' . $e->getMessage());
					line_break();
				}
			}
		} else {
			echo danger("The file '$file' does not exist.");
			line_break();
		}
	} else {
		$scandir = scandir('database');

		foreach ($scandir as $item) {
			if (!is_dir($item)) {
				$sql = file_get_contents('database/' . $item);
				$sql = trim($sql);

				if (config('database', 'driver') == 'sqlite') {
					$sql = str_replace('AUTO_INCREMENT', 'AUTOINCREMENT', $sql);
				}

				if (strlen($sql)) {
					try {
						foreach (explode(';', $sql) as $sentence) {
							if (strlen($sentence)) {
								Illuminate\Database\Capsule\Manager::select($sentence);
							}
						}

						echo success($item . ' is ok.');
						echo line_break();
					}
					catch (PDOException $e) {
						echo danger($item . ' has an error: ' . $e->getMessage());
						line_break();
					}					
				}
			}
		}		
	}
}