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
		$this->schema->create('countries', function ($table) {
            $table->id();

            $table->string('name');

            $table->string('iso3')
            	->unique();

            $table->string('iso2')
            	->unique()
            	->nullable();

            $table->string('phonecode');

            $table->string('capital')
            	->nullable();

            $table->string('currency');

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
        $this->schema->dropIfExists('countries');
    }
};
