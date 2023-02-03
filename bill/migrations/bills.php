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
		$this->schema->create('bills', function ($table) {
            $table->id();
            $table->unsignedBigInteger('id_customer');

            $table->float('discount')
                ->nullable();

            $table->float('tax')
                ->nullable();

            $table->float('total');

            $table->datetime('date_create')
                ->useCurrent();

            $table->datetime('date_update')
                ->useCurrent()
                ->setCurrentOnUpdate();

            $table->foreign('id_customer')
                ->references('id')
                ->on('customers');
        });
	}

	/**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        $this->schema->dropIfExists('bills');
    }
}
