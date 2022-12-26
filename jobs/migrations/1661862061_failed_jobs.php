<?php

$schema['default']->dropIfExists('failed_jobs');

$schema['default']->create('failed_jobs', function ($table) {
	$table->id();
    $table->string('queue');
    $table->text('payload');
    $table->text('exception');
    $table->timestamp('date_fail')->useCurrent();
});
