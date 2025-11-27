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
        Schema::table('donation_items_catalog', function (Blueprint $table) {
            $table->string('category')->default('Otro')->after('description'); 
            $table->integer('quantity_needed')->default(1)->after('category');
            $table->unsignedBigInteger('id_shelter')->nullable()->after('quantity_needed');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('donation_items_catalog', function (Blueprint $table) {
            $table->dropColumn(['category', 'quantity_needed', 'id_shelter']);
        });
    }
};
