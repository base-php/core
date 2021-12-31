<?php

$schema->dropIfExists('MigrationName');

$schema->create('MigrationName', function ($table) {
	$table->id();

	$table->datetime('date_create')->useCurrent();
	$table->datetime('date_update')->useCurrent()->setCurrentOnUpdate();
});

for ($i = 0; $i < 99; $i++) {
    $VarName = App\Models\ModelName::create([]);
}
