<?php

$schema['default']->dropIfExists();

$schema['default']->create('roles', function ($table) {
	$table->id();

	$table->string('name');
	$table->string('description');

	$table->datetime('date_create')
		->useCurrent();

	$table->datetime('date_update')
		->useCurrent()
		->setCurrentOnUpdate();
});
