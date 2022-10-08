<?php

$schema['default']->dropIfExists();

$schema['default']->create('role_has_permissions', function ($table) {
	$table->id();

	$table->int('id_role');
	$table->int('id_permission');

	$table->datetime('date_create')
		->useCurrent();

	$table->datetime('date_update')
		->useCurrent()
		->setCurrentOnUpdate();

	$table->foreign('id_role')
		->references('id')
		->on('roles');

	$table->foreign('id_permission')
		->references('id')
		->on('permissions');
});
