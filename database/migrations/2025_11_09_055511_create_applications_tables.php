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
        Schema::create('application_statuses', function (Blueprint $table) {
        $table->bigIncrements('id_status');
        $table->string('status_name')->unique();
        });

        Schema::create('adoption_applications', function (Blueprint $table) {
            $table->bigIncrements('id_adoption_application');
            $table->date('application_date');
            $table->foreignId('id_user')->constrained(table: 'users', column: 'id_user');
            $table->foreignId('id_animal')->constrained(table: 'animals', column: 'id_animal');
            $table->foreignId('id_status')->constrained(table: 'application_statuses', column: 'id_status');
            $table->foreignId('approved_by_id_admin')->nullable()->constrained(table: 'users', column: 'id_user');
            $table->text('admin_notes')->nullable();
        });

        Schema::create('volunteer_applications', function (Blueprint $table) {
            $table->bigIncrements('id_volunteer_applications');
            $table->text('motivation');
            $table->date('application_date');
            $table->foreignId('id_user')->constrained(table: 'users', column: 'id_user');
            $table->foreignId('id_status')->constrained(table: 'application_statuses', column: 'id_status');
            $table->foreignId('reviewed_by_id_admin')->nullable()->constrained(table: 'users', column: 'id_user');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('volunteer_applications');
        Schema::dropIfExists('adoption_applications');
        Schema::dropIfExists('application_statuses');
    }
};
