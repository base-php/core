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
		$this->schema->create('currencies', function ($table) {
            $table->id();

            $table->string('code')
                ->unique();

            $table->string('name');

            $table->decimal('exchange_rate', 10, 4);

            $table->string('format');
            $table->string('decimal_point');
            $table->string('thousand_point');

            $table->integer('decimal_places')
                ->default(2)
                ->index();

            $table->boolean('enabled')
                ->default(0)
                ->index();

            $table->boolean('default')
                ->default(0)
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
        $this->schema->dropIfExists('currencies');
    }
};
