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
        Schema::table('donation_applications', function (Blueprint $table) {
            $table->index('id_status');
            $table->index('id_user');
            $table->index('application_date');
        });
        Schema::table('donation_application_items', function (Blueprint $table){
            $table->index('id_donation_application');
            $table->index('id_donation_item_catalog');
        });
        Schema::table('donation_items_catalog',function(Blueprint $table){
            $table->index('id_shelter');
            $table->index('category');
            $table->index('item_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('donation_applications', function (Blueprint $table) {
            $table->dropIndex(['id_user']);
            $table->dropIndex(['id_status']);
            $table->dropIndex(['application_date']);
        });

        Schema::table('donation_application_items', function (Blueprint $table) {
            $table->dropIndex(['id_donation_application']);
            $table->dropIndex(['id_donation_item_catalog']);
        });

        Schema::table('donation_items_catalog', function (Blueprint $table) {
            $table->dropIndex(['id_shelter']);
            $table->dropIndex(['category']);
            $table->dropIndex(['item_name']);
        });
    }
};
