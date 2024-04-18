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
		$this->schema->create('bills_items', function ($table) {
            $table->id();
            $table->unsignedBigInteger('bill_id');

            $table->text('description');
            $table->integer('quantity');
            $table->float('price');
            $table->float('tax');
            $table->float('discount');

            $table->datetime('date_create')
                ->useCurrent();

            $table->datetime('date_update')
                ->useCurrent()
                ->setCurrentOnUpdate();

            $table->foreign('bill_id')
                ->references('id')
                ->on('bills');
        });
	}

	/**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        $this->schema->dropIfExists('bills_items');
    }
};
