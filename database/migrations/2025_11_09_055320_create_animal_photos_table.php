<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('animal_photos', function (Blueprint $table) {
            $table->bigIncrements('id_animal_photos');
            $table->string('image_url');
            $table->foreignId('id_animal')->constrained(table: 'animals', column: 'id_animal')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('animal_photos');
    }
};
