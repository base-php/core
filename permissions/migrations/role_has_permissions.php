<?php

return new class extends Migration
{
	/**
     * Run the migrations.
     *
     * @return void
     */
	public function up(): void
	{
		$this->schema->create('role_has_permissions', function ($table) {
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
	}
	/**
     * Reverse the migrations.
     *
     * @return void
     */
	public function down(): void
	{
		$this->schema->dropIfExists('role_has_permissions');
	}
};
