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
        $this->schema->create('orders', function ($table) {
            $table->id();

            $table->string('status')
                ->index();

            $table->string('reference')
                ->nullable()
                ->unique();

            $table->string('customer_id')
                ->nullable();

            $table->integer('subtotal')
                ->unsigned()
                ->index();

            $table->integer('discount')
                ->default(0)
                ->unsigned()
                ->index();

            $table->integer('shipping')
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

            $table->string('currency', 3);

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
        $this->schema->dropIfExists('orders');
    }
};
