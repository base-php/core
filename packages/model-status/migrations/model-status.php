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
		$this->schema->create('model_status', function ($table) {
            $table->id();

            $table->string('name');
            $table->text('reason')->nullable();

            $table->string('model');
            $table->int('id_model');

            $table->datetime('date_create')
                ->useCurrent();

            $table->datetime('date_update')
                ->useCurrent()
                ->setCurrentOnUpdate();

            $table->unique(['name']);
        });
	}

	/**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        $this->schema->dropIfExists('features');
    }
};
