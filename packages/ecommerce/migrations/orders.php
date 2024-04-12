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

            $table->string('customer_reference')
                ->nullable();

            $table->integer('sub_total')
                ->unsigned()
                ->index();

            $table->integer('discount_total')
                ->default(0)
                ->unsigned()
                ->index();

            $table->integer('shipping_total')
                ->default(0)
                ->unsigned()
                ->index();

            $table->integer('tax_total')
                ->unsigned()
                ->index();

            $table->integer('total')
                ->unsigned()
                ->index();

            $table->text('notes')
                ->nullable();

            $table->string('currency_code', 3);

            $table->decimal('exchange_rate', 10, 4)
                ->default(1);

            $table->dateTime('placed_at')
                ->nullable()
                ->index();

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
