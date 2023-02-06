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
		$this->schema->create('customers', function ($table) {
            $table->id();
            $table->int('id_model');
            $table->string('model');

            $table->text('address');
            $table->text('city');
            $table->text('state');
            $table->text('postal_code');
            $table->text('country');
            $table->text('phone');

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
        $this->schema->dropIfExists('customers');
    }
}
