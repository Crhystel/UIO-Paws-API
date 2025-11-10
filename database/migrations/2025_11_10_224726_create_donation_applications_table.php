<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('donation_applications', function (Blueprint $table) {
            $table->bigIncrements('id_donation_application');
            $table->foreignId('id_user')->constrained('users', 'id_user');
            $table->date('application_date');
            $table->foreignId('id_status')->constrained('application_statuses', 'id_status');
            $table->foreignId('reviewed_by_id_admin')->nullable()->constrained('users', 'id_user');
            $table->text('admin_notes')->nullable();
        });

        Schema::create('donation_application_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('id_donation_application')->constrained('donation_applications', 'id_donation_application')->onDelete('cascade');
            $table->foreignId('id_donation_item_catalog')->constrained('donation_items_catalog', 'id_donation_item_catalog');
            $table->integer('quantity');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('donation_application_items');
        Schema::dropIfExists('donation_applications');
    }
};