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
        $this->schema->create('notifications', function ($table) {
            $table->id();
            $table->string('type');
            $table->text('data');
            $table->datetime('date_read')->nullable();
            $table->datetime('date_create')->useCurrent();
            $table->datetime('date_update')->useCurrent()->setCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        $this->schema->dropIfExists('notifications');
    }
};
