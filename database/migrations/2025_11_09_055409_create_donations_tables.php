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
        Schema::create('donation_items_catalog', function (Blueprint $table) {
            $table->bigIncrements('id_donation_item_catalog');
            $table->string('item_name')->unique();
            $table->text('description')->nullable();
        });

        Schema::create('donations', function (Blueprint $table) {
            $table->bigIncrements('id_donation');
            $table->date('donation_date');
            $table->foreignId('id_user')->constrained(table: 'users', column: 'id_user');
            $table->string('delivery_status');
        });

        Schema::create('donation_item', function (Blueprint $table) {
            $table->bigIncrements('id_donation_item');
            $table->foreignId('id_donation')->constrained(table: 'donations', column: 'id_donation')->onDelete('cascade');
            $table->foreignId('id_donation_item_catalog')->constrained(table: 'donation_items_catalog', column: 'id_donation_item_catalog');
            $table->integer('quantity');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('donation_item');
        Schema::dropIfExists('donations');
        Schema::dropIfExists('donation_items_catalog');
    }
};
