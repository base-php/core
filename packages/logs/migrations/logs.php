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
        $this->schema->create('logs', function ($table) {
            $table->id();

            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('model_id')->nullable();

            $table->string('model')->nullable();
            $table->string('action');

            $table->text('parameters')->nullable();

            $table->datetime('date_create')->useCurrent();
            $table->datetime('date_update')->useCurrent()->setCurrentOnUpdate();

            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        $this->schema->dropIfExists('logs');
    }
};
