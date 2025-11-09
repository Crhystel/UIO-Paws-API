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
        Schema::create('animals', function (Blueprint $table) {
            $table->bigIncrements('id_animal');
            $table->string('animal_name');
            $table->string('status')->default('Disponible');
            $table->date('birth_date')->nullable();
            $table->string('color');
            $table->boolean('is_sterilized')->default(false);
            $table->text('description')->nullable();
            $table->foreignId('id_breed')->constrained(table: 'breeds', column: 'id_breed');
            $table->foreignId('id_shelter')->constrained(table: 'shelters', column: 'id_shelter');
            $table->string('sex');
            $table->integer('age')->nullable();
            $table->string('size');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('animals');
    }
};
