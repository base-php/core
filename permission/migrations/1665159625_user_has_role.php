<?php

$schema['default']->dropIfExists();

$schema['default']->create('user_has_roles', function ($table) {
	$table->id();

	$table->int('id_user');
	$table->int('id_role');

	$table->datetime('date_create')
		->useCurrent();

	$table->datetime('date_update')
		->useCurrent()
		->setCurrentOnUpdate();

	$table->foreign('id_user')
		->references('id')
		->on('users');

	$table->foreign('id_role')
		->references('id')
		->on('roles');
});
