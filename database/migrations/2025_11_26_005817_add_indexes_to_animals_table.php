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
        Schema::table('animals', function (Blueprint $table) {
            $table->index('status');
            $table->index('id_breed');
            $table->index('id_shelter');
            $table->index('size');
            $table->index('color');
            $table->index('sex');
            $table->index('animal_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('animals', function (Blueprint $table) {
            $table->index('status');
            $table->index('id_breed');
            $table->index('id_shelter');
            $table->index('size');
            $table->index('color');
            $table->index('sex');
            $table->index('animal_name');
        });
    }
};
