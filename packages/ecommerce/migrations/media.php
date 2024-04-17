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
		$this->schema->create('media', function ($table) {
            $table->id();

            $table->string('model');
            $table->int('model_id');

            $table->string('filename');

            $table->datetime('date_create')
                ->useCurrent();

            $table->datetime('date_update')
                ->useCurrent()
                ->setCurrentOnUpdate();
        });
	}

	/**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        $this->schema->dropIfExists('media');
    }
};
