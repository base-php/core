<?php

class Migration
{
	public $connection;

	public $schema;

	public function __construct()
	{
		include 'vendor/base-php/core/database/database.php';

		$this->connection = $this->connection ?? 'default';
		$this->schema = $capsule->getConnection($this->connection)->getSchemaBuilder();

		if (!$this->schema->hasTable('migrations')) {
			$this->schema->create('migrations', function ($table) {
				$table->id();
				$table->string('name');
				$table->integer('batch');
			});
		}
	}
}
