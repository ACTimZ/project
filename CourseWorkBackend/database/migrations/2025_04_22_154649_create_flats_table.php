<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('flats', function (Blueprint $table) {
            $table->id();
            $table->integer('rooms_count');
            $table->decimal('square_meters', 8, 2);
            $table->integer('floor');
            $table->integer('floors_in_house');
            $table->string('housing_complex');
            $table->decimal('price_current', 12, 2);
            $table->decimal('price_start', 12, 2);
            $table->boolean('has_balcony');
            $table->boolean('bathroom_combined');
            $table->enum('house_type', ['brick', 'panel', 'aerated_concrete']);
            $table->text('description');
            $table->json('images');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('flats');
    }
};
