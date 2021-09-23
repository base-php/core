<?php

$schema->dropIfExists('MigrationName');

$schema->create('MigrationName', function ($table) {
	$table->id();

	$table->datetime('date_create')->useCurrent();
	$table->datetime('date_update')->useCurrent()->setCurrentOnUpdate();
});
