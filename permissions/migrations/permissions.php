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
        $this->schema->create('permissions', function ($table) {
            $table->id();

            $table->string('name');
            $table->string('description');

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
        $this->schema->dropIfExists('permissions');
    }
};
