<?php

$schema['default']->dropIfExists('logs');

$schema['default']->create('logs', function ($table) {
	$table->id();

	$table->unsignedBigInteger('id_user');
	$table->unsignedBigInteger('id_model');

	$table->string('model');
	$table->string('action');

	$table->text('parameters');

	$table->datetime('date_create')->useCurrent();
	$table->datetime('date_update')->useCurrent()->setCurrentOnUpdate();

	$table->foreign('id_user')->references('id')->on('users');
});
