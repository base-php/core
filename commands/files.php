<?php

// Create controllers
if (isset($_SERVER['argv'][1]) && strpos($_SERVER['argv'][1], 'create-controller=') === 0) {
	$name = str_replace('create-controller=', '', $_SERVER['argv'][1]);

	if ($name == '') {
		echo danger('You have not specified a name for the controller.');
		line_break();
		exit;
	}

	$content = file_get_contents('vendor/nisadelgado/framework/commands/examples/Controller.php');
	$content = str_replace('ControllerName', $name, $content);

	$fopen = fopen('app/Controllers/' . $name . '.php', 'w+');
	fwrite($fopen, $content);
	fclose($fopen);

	echo success("Controller '$name' created successfully.");
	line_break();
}


// Create excel
if (isset($_SERVER['argv'][1]) && strpos($_SERVER['argv'][1], 'create-excel=') === 0) {
	$name = str_replace('create-excel=', '', $_SERVER['argv'][1]);

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
if (isset($_SERVER['argv'][1]) && strpos($_SERVER['argv'][1], 'create-mail=') === 0) {
	$name = str_replace('create-mail=', '', $_SERVER['argv'][1]);

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
if (isset($_SERVER['argv'][1]) && strpos($_SERVER['argv'][1], 'create-middleware=') === 0) {
	$name = str_replace('create-middleware=', '', $_SERVER['argv'][1]);

	if ($name == '') {
		echo danger('You have not specified a name for the middleware.');
		line_break();
		exit;
	}

	$content = file_get_contents('vendor/nisadelgado/framework/commands/examples/Middleware.php');
	$content = str_replace('MiddlewareName', $name, $content);

	$fopen = fopen('app/Middleware/' . $name . '.php', 'w+');
	fwrite($fopen, $content);
	fclose($fopen);

	echo success("Middleware '$name' created successfully.");
	line_break();
}


// Create models
if (isset($_SERVER['argv'][1]) && strpos($_SERVER['argv'][1], 'create-model=') === 0) {
	$name = str_replace('create-model=', '', $_SERVER['argv'][1]);

	if ($name == '') {
		echo danger('You have not specified a name for the model.');
		line_break();
		exit;
	}

	$content = file_get_contents('vendor/nisadelgado/framework/commands/examples/Model.php');
	$content = str_replace('ModelName', $name, $content);

	$fopen = fopen('app/Models/' . $name . '.php', 'w+');
	fwrite($fopen, $content);
	fclose($fopen);

	echo success("Model '$name' created successfully.");
	line_break();
}


// Create PDF
if (isset($_SERVER['argv'][1]) && strpos($_SERVER['argv'][1], 'create-pdf=') === 0) {
	$name = str_replace('create-pdf=', '', $_SERVER['argv'][1]);

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


// Create SQL
if (isset($_SERVER['argv'][1]) && strpos($_SERVER['argv'][1], 'create-sql=') === 0) {
	$name = str_replace('create-sql=', '', $_SERVER['argv'][1]);

	if ($name == '') {
		echo danger('You have not specified a name for the SQL.');
		line_break();
		exit;
	}

	$name = time() . '_' . $name;

	$fopen = fopen('database/' . $name . '.sql', 'w+');
	fclose($fopen);

	echo success("SQL '$name.sql' created successfully.");
	line_break();
}


// Create validations
if (isset($_SERVER['argv'][1]) && strpos($_SERVER['argv'][1], 'create-validation=') === 0) {
	$name = str_replace('create-validation=', '', $_SERVER['argv'][1]);

	if ($name == '') {
		echo danger('You have not specified a name for the validation.');
		line_break();
		exit;
	}

	$content = file_get_contents('vendor/nisadelgado/framework/commands/examples/Validation.php');
	$content = str_replace('ValidationName', $name, $content);

	$fopen = fopen('app/Validations/' . $name . '.php', 'w+');
	fwrite($fopen, $content);
	fclose($fopen);

	echo success("Validation '$name' created successfully.");
	line_break();
}
