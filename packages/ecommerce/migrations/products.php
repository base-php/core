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
		$this->schema->create('products', function ($table) {
            $table->id();

            $table->foreignId('product_type_id')
            	->constrained('product_types');

            $table->string('status')->index();

            $table->json('attribute_data');

            $table->string('brand')
            	->nullable()
            	->index();

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
        $this->schema->dropIfExists('products');
    }
};
