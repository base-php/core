<?php

if (!isset($_SERVER['argv'][1])) {
	line_break();
	echo normal('Base PHP 1.0.0 by Nisa Delgado.');
	line_break(2);

	echo warning('Usage:');
	echo line_break();

	echo normal('  command [key]=[value]');
	echo line_break(2);


	echo warning('Available commands:');
	echo line_break();

	echo success('  create-controller');
	echo normal('	Create a controller with the given name.');
	echo line_break();

	echo success('  create-database');
	echo normal('	Create a database with the name set in config file.');
	echo line_break();

	echo success('  create-mail');
	echo normal('		Create a mail with the given name.');
	echo line_break();

	echo success('  create-middleware');
	echo normal('	Create a middleware with the given name.');
	echo line_break();

	echo success('  create-model');
	echo normal('		Create a model with the given name.');
	echo line_break();

	echo success('  create-sql');
	echo normal('		Create a SQL file with the given name.');
	echo line_break();

	echo success('  create-validation');
	echo normal('	Create a validation with the given name.');
	echo line_break();

	echo success('  run-sql');
	echo normal('		Execute an SQL file on the database.');
	echo line_break();

	echo success('  server');
	echo normal('		Build development server on port 8080.');
	echo line_break(2);
}
