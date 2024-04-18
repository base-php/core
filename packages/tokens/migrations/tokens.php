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
        $this->schema->create('tokens', function ($table) {
            $table->id();
            $table->string('name');
            $table->string('model');
            $table->int('model_id');
            $table->string('token', 64)->unique();
            $table->timestamp('date_expire')->nullable();
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
        $this->schema->dropIfExists('tokens');
    }
};
