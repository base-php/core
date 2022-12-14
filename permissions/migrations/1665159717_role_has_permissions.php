<?php

$schema['default']->dropIfExists('role_has_permissions');

$schema['default']->create('role_has_permissions', function ($table) {
	$table->id();

	$table->unsignedBigInteger('id_role');
	$table->unsignedBigInteger('id_permission');

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
