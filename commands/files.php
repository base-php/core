<?php

// Create controllers
if (isset($_SERVER['argv'][1]) && strpos($_SERVER['argv'][1], 'make-controller=') === 0) {
	$name = str_replace('make-controller=', '', $_SERVER['argv'][1]);

	if ($name == '') {
		echo danger('You have not specified a name for the controller.');
		line_break();
		exit;
	}

	$content = file_get_contents('vendor/nisadelgado/framework/commands/examples/Controller.php');
	$content = str_replace('ControllerName', $name, $content);

	if (!file_exists('app/Controllers')) {
		mkdir('app/Controllers');
	}

	$fopen = fopen('app/Controllers/' . $name . '.php', 'w+');
	fwrite($fopen, $content);
	fclose($fopen);

	echo success("Controller '$name' created successfully.");
	line_break();
}


// Create Excel
if (isset($_SERVER['argv'][1]) && strpos($_SERVER['argv'][1], 'make-excel=') === 0) {
	$name = str_replace('make-excel=', '', $_SERVER['argv'][1]);

	if ($name == '') {
		echo danger('You have not specified a name for the Excel.');
		line_break();
		exit;
	}

	$content = file_get_contents('vendor/nisadelgado/framework/commands/examples/Excel.php');
	$content = str_replace('ExcelName', $name, $content);

	if (!file_exists('app/Excel')) {
		mkdir('app/Excel');
	}

	$fopen = fopen('app/Excel/' . $name . '.php', 'w+');
	fwrite($fopen, $content);
	fclose($fopen);

	echo success("Excel '$name' created successfully.");
	line_break();
}


// Create mail
if (isset($_SERVER['argv'][1]) && strpos($_SERVER['argv'][1], 'make-mail=') === 0) {
	$name = str_replace('make-mail=', '', $_SERVER['argv'][1]);

	if ($name == '') {
		echo danger('You have not specified a name for the mail.');
		line_break();
		exit;
	}

	$content = file_get_contents('vendor/nisadelgado/framework/commands/examples/Mail.php');
	$content = str_replace('MailName', $name, $content);

	if (!file_exists('app/Mails')) {
		mkdir('app/Mails');
	}

	$fopen = fopen('app/Mails/' . $name . '.php', 'w+');
	fwrite($fopen, $content);
	fclose($fopen);

	echo success("Mail '$name' created successfully.");
	line_break();
}


// Create middleware
if (isset($_SERVER['argv'][1]) && strpos($_SERVER['argv'][1], 'make-middleware=') === 0) {
	$name = str_replace('make-middleware=', '', $_SERVER['argv'][1]);

	if ($name == '') {
		echo danger('You have not specified a name for the middleware.');
		line_break();
		exit;
	}

	$content = file_get_contents('vendor/nisadelgado/framework/commands/examples/Middleware.php');
	$content = str_replace('MiddlewareName', $name, $content);

	if (!file_exists('app/Middleware')) {
		mkdir('app/Middleware');
	}

	$fopen = fopen('app/Middleware/' . $name . '.php', 'w+');
	fwrite($fopen, $content);
	fclose($fopen);

	echo success("Middleware '$name' created successfully.");
	line_break();
}


// Create migration
if (isset($_SERVER['argv'][1]) && strpos($_SERVER['argv'][1], 'make-migration=') === 0) {
	$name = str_replace('make-migration=', '', $_SERVER['argv'][1]);

	if ($name == '') {
		echo danger('You have not specified a name for the migration.');
		line_break();
		exit;
	}

	$content = file_get_contents('vendor/nisadelgado/framework/commands/examples/Migration.php');
	$content = str_replace('MigrationName', $name, $content);

	if (!file_exists('database')) {
		mkdir('database');
	}

	$name = time() . '_' . $name;

	$fopen = fopen('database/' . $name . '.php', 'w+');
	fwrite($fopen, $content);
	fclose($fopen);

	echo success("Migration '$name' created successfully.");
	line_break();
}


// Create models
if (isset($_SERVER['argv'][1]) && strpos($_SERVER['argv'][1], 'make-model=') === 0) {
	$name = str_replace('make-model=', '', $_SERVER['argv'][1]);

	if ($name == '') {
		echo danger('You have not specified a name for the model.');
		line_break();
		exit;
	}

	$content = file_get_contents('vendor/nisadelgado/framework/commands/examples/Model.php');
	$content = str_replace('ModelName', $name, $content);

	if (!file_exists('app/Models')) {
		mkdir('app/Models');
	}

	$fopen = fopen('app/Models/' . $name . '.php', 'w+');
	fwrite($fopen, $content);
	fclose($fopen);

	echo success("Model '$name' created successfully.");
	line_break();
}


// Create PDF
if (isset($_SERVER['argv'][1]) && strpos($_SERVER['argv'][1], 'make-pdf=') === 0) {
	$name = str_replace('make-pdf=', '', $_SERVER['argv'][1]);

	if ($name == '') {
		echo danger('You have not specified a name for the PDF.');
		line_break();
		exit;
	}

	$content = file_get_contents('vendor/nisadelgado/framework/commands/examples/PDF.php');
	$content = str_replace('PDFName', $name, $content);

	if (!file_exists('app/PDF')) {
		mkdir('app/PDF');
	}

	$fopen = fopen('app/PDF/' . $name . '.php', 'w+');
	fwrite($fopen, $content);
	fclose($fopen);

	echo success("PDF '$name' created successfully.");
	line_break();
}


// Create resources
if (isset($_SERVER['argv'][1]) && strpos($_SERVER['argv'][1], 'make-resource=') === 0) {
	$name = str_replace('make-resource=', '', $_SERVER['argv'][1]);

	if ($name == '') {
		echo danger('You have not specified a name for the resource.');
		line_break();
		exit;
	}

	$content = file_get_contents('vendor/nisadelgado/framework/commands/examples/Resource.php');
	$content = str_replace('ResourceName', $name, $content);

	if (!file_exists('app/Resources')) {
		mkdir('app/Resources');
	}

	$fopen = fopen('app/Resources/' . $name . '.php', 'w+');
	fwrite($fopen, $content);
	fclose($fopen);

	echo success("Resource '$name' created successfully.");
	line_break();
}


// Create rule
if (isset($_SERVER['argv'][1]) && strpos($_SERVER['argv'][1], 'make-rule=') === 0) {
	$name = str_replace('make-rule=', '', $_SERVER['argv'][1]);

	if ($name == '') {
		echo danger('You have not specified a name for the rule.');
		line_break();
		exit;
	}

	$content = file_get_contents('vendor/nisadelgado/framework/commands/examples/Rule.php');
	$content = str_replace('RuleName', $name, $content);

	if (!file_exists('app/Rules')) {
		mkdir('app/Rules');
	}

	$fopen = fopen('app/Rules/' . $name . '.php', 'w+');
	fwrite($fopen, $content);
	fclose($fopen);

	echo success("Rule '$name' created successfully.");
	line_break();
}


// Create test
if (isset($_SERVER['argv'][1]) && strpos($_SERVER['argv'][1], 'make-test=') === 0) {
	$name = str_replace('make-test=', '', $_SERVER['argv'][1]);

	if ($name == '') {
		echo danger('You have not specified a name for the test.');
		line_break();
		exit;
	}

	$content = file_get_contents('vendor/nisadelgado/framework/commands/examples/Test.php');
	$content = str_replace('TestName', $name, $content);

	$fopen = fopen('tests/' . $name . '.php', 'w+');
	fwrite($fopen, $content);
	fclose($fopen);

	echo success("Test '$name' created successfully.");
	line_break();
}


// Create validations
if (isset($_SERVER['argv'][1]) && strpos($_SERVER['argv'][1], 'make-validation=') === 0) {
	$name = str_replace('make-validation=', '', $_SERVER['argv'][1]);

	if ($name == '') {
		echo danger('You have not specified a name for the validation.');
		line_break();
		exit;
	}

	$content = file_get_contents('vendor/nisadelgado/framework/commands/examples/Validation.php');
	$content = str_replace('ValidationName', $name, $content);

	if (!file_exists('app/Validations')) {
		mkdir('app/Validations');
	}

	$fopen = fopen('app/Validations/' . $name . '.php', 'w+');
	fwrite($fopen, $content);
	fclose($fopen);

	echo success("Validation '$name' created successfully.");
	line_break();
}
