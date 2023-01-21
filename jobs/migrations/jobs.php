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
        $this->schema->create('jobs', function ($table) {
            $table->id();
            $table->string('queue');
            $table->text('payload');
            $table->integer('attempts');
            $table->integer('date_reserve');

            $table->integer('date_create')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        $this->schema->dropIfExists('jobs');
    }
};
