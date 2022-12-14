<?php

$schema['default']->dropIfExists('tokens');

$schema['default']->create('tokens', function ($table) {
	$table->id();
	$table->string('id_user');
	$table->string('token')->unique();
	$table->timestamp('date_expire');
	$table->datetime('date_create')->useCurrent();
	$table->datetime('date_update')->useCurrent()->setCurrentOnUpdate();
});
