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
		$this->schema->create('adresses', function ($table) {
            $table->id();

            $table->foreignId('customer_id')
            	->nullable()
            	->constrained('customers');

            $table->foreignId('country_id')
            	->nullable()
            	->constrained('countries');

            $table->string('title')
            	->nullable();

            $table->string('name');
            $table->string('city');

            $table->string('state')
            	->nullable();

            $table->string('postcode')->nullable();

            $table->string('email')->nullable();
            $table->string('phone')->nullable();

            $table->boolean('shipping_default')
            	->default(false);

            $table->boolean('billing_default')
            	->default(false);

            $table->json('meta')
                ->nullable();

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
        $this->schema->dropIfExists('adresses');
    }
};
