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
		$this->schema->create('features', function ($table) {
            $table->id();

            $table->string('name');
            $table->string('scope');
            $table->text('value');
            
            $table->datetime('date_read')
                ->nullable();

            $table->datetime('date_create')
                ->useCurrent();

            $table->datetime('date_update')
                ->useCurrent()
                ->setCurrentOnUpdate();

            $table->unique(['name', 'scope']);
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
