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
        Schema::create('medical_records', function (Blueprint $table) {
            $table->bigIncrements('id_medical_records');
            $table->date('event_date');
            $table->text('description');
            $table->string('event_type');
            $table->string('veterinarian_name')->nullable();
            $table->string('medication')->nullable();
            $table->foreignId('id_animal')->constrained(table: 'animals', column: 'id_animal')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medical_records');
    }
};
