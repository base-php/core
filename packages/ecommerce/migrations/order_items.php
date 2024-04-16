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
        $this->schema->create('order_items', function ($table) {
            $table->id();         

            $table->foreignId('order_id')
                ->constrained('orders');

            $table->string('type')
                ->index();

            $table->string('description');

            $table->integer('price')
                ->unsigned()
                ->index();

            $table->smallInteger('quantity')
                ->unsigned();

            $table->integer('subtotal')
                ->unsigned()
                ->index();

            $table->integer('discount')
                ->default(0)
                ->unsigned()
                ->index();

            $table->integer('tax')
                ->unsigned()
                ->index();

            $table->integer('total')
                ->unsigned()
                ->index();

            $table->text('notes')
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
        $this->schema->dropIfExists('order_items');
    }
};
