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
        $this->schema->create('order_addresses', function ($table) {
            $table->id();

            $table->foreignId('order_id')
                ->constrained('orders');

            $table->foreignId('country_id')
                ->nullable()
                ->constrained('countries');

            $table->string('title')
                ->nullable();

            $table->string('name')
                ->nullable();

            $table->string('city')
                ->nullable();

            $table->string('state')
                ->nullable();

            $table->string('zip_code')
                ->nullable();
                
            $table->string('email')
                ->nullable();

            $table->string('phone')
                ->nullable();

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
        $this->schema->dropIfExists('order_addresses');
    }
};
