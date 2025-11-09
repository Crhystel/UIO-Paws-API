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
        Schema::create('emergency_contacts', function (Blueprint $table) {
        $table->bigIncrements('id_emergency_contacts');
        $table->foreignId('id_user')->constrained(table: 'users', column: 'id_user')->onDelete('cascade');
        $table->string('contact_name');
        $table->string('contact_phone');
        $table->string('relationship');
        });

        Schema::create('terms_and_conditions', function (Blueprint $table) {
            $table->bigIncrements('id_terms_conditions');
            $table->longText('full_text');
            $table->string('version');
            $table->date('publication_date');
        });

        Schema::create('user_term_acceptance', function (Blueprint $table) {
            $table->bigIncrements('id_user_acceptance');
            $table->foreignId('id_user')->constrained(table: 'users', column: 'id_user')->onDelete('cascade');
            $table->foreignId('id_terms_conditions')->constrained(table: 'terms_and_conditions', column: 'id_terms_conditions');
            $table->timestamp('acceptance_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_term_acceptance');
        Schema::dropIfExists('terms_and_conditions');
        Schema::dropIfExists('emergency_contacts');
    }
};
