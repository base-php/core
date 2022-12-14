<?php

$schema['default']->dropIfExists('tokens');

$schema['default']->create('tokens', function ($table) {
	$table->id();
	$table->string('id_user');
	$table->string('token')->unique();
	$table->datetime('date_create')->useCurrent();
	$table->datetime('date_update')->useCurrent()->setCurrentOnUpdate();
	$table->datetime('date_expire');
});
