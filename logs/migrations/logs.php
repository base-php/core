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
		$this->schema->create('logs', function ($table) {
			$table->id();

			$table->unsignedBigInteger('id_user')->nullable();
			$table->unsignedBigInteger('id_model')->nullable();

			$table->string('model')->nullable();
			$table->string('action');

			$table->text('parameters')->nullable();

			$table->datetime('date_create')->useCurrent();
			$table->datetime('date_update')->useCurrent()->setCurrentOnUpdate();

			$table->foreign('id_user')->references('id')->on('users');
		});
	}
	/**
     * Reverse the migrations.
     *
     * @return void
     */
	public function down(): void
	{
		$this->schema->dropIfExists('logs');
	}
};
