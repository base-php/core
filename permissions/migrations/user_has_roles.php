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
		$this->schema->create('user_has_roles', function ($table) {
			$table->id();

			$table->unsignedBigInteger('id_user');
			$table->unsignedBigInteger('id_role');

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
	}
	
	/**
     * Reverse the migrations.
     *
     * @return void
     */
	public function down(): void
	{
		$this->schema->dropIfExists('user_has_roles');
	}
};
