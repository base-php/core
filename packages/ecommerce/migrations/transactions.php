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
        $this->schema->create('transactions', function ($table) {
            $table->id();

            $table->foreignId('order_id')
                ->constrained('orders');

            $table->boolean('success')
                ->index();

            $table->boolean('refund')
                ->default(false)
                ->index();

            $table->string('driver');

            $table->integer('amount')
                ->unsigned()
                ->index();

            $table->string('reference')
                ->index();

            $table->string('status');

            $table->string('notes')
                ->nullable();

            $table->string('card_type', 25)
                ->index();

            $table->smallInteger('last_four');

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
        $this->schema->dropIfExists('transactions');
    }
};
