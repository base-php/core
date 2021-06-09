<?php

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