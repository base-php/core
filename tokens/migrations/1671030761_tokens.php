<?php

$schema['default']->dropIfExists('tokens');

$schema['default']->create('tokens', function ($table) {
	$table->id();
	$table->string('name');
	$table->string('model');
	$table->int('id_model');
	$table->string('token', 64)->unique();
	$table->timestamp('date_expire')->nullable();
	$table->datetime('date_create')->useCurrent();
	$table->datetime('date_update')->useCurrent()->setCurrentOnUpdate();
});
