<?php

if (!isset($_SERVER['argv'][1])) {
	line_break();
	echo normal('Base PHP 1.3.91 by Nisa Delgado.');
	line_break(2);

	echo warning('Usage:');
	echo line_break();

	echo normal('  command [key]=[value]');
	echo line_break(2);


	echo warning('Available commands:');
	echo line_break();

	echo success('  make-controller');
	echo normal('	Create a controller with the given name.');
	echo line_break();

	echo success('  make-database');
	echo normal('		Create a database with the name set in config file.');
	echo line_break();

	echo success('  make-excel');
	echo normal('		Create a Excel with the given name.');
	echo line_break();

	echo success('  make-mail');
	echo normal('		Create a mail with the given name.');
	echo line_break();

	echo success('  make-middleware');
	echo normal('	Create a middleware with the given name.');
	echo line_break();

	echo success('  make-migration');
	echo normal('	Create a migration file with the given name.');
	echo line_break();

	echo success('  make-model');
	echo normal('		Create a model with the given name.');
	echo line_break();

	echo success('  make-pdf');
	echo normal('		Create a PDF file with the given name.');
	echo line_break();

	echo success('  make-resource');
	echo normal('		Create a resource file with the given name.');
	echo line_break();

	echo success('  make-rule');
	echo normal('		Create a rule file with the given name.');
	echo line_break();

	echo success('  make-test');
	echo normal('		Create a test with the given name.');
	echo line_break();

	echo success('  make-validation');
	echo normal('	Create a validation with the given name.');
	echo line_break();

	echo success('  metrics');
	echo normal('		Generate a static analysis with PhpMetrics.');
	echo line_break();

	echo success('  migrate');
	echo normal('		Migrate all files to database.');
	echo line_break();

	echo success('  server');
	echo normal('		Build development server on port 8080.');
	echo line_break();

	echo success('  test');
	echo normal('			Run unit tests.');
	echo line_break(2);
}
