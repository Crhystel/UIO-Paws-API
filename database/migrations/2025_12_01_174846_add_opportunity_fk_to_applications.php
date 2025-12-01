<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasColumn('volunteer_applications', 'id_volunteer_opportunity')) {
            Schema::table('volunteer_applications', function (Blueprint $table) {
                $table->dropColumn('id_volunteer_opportunity');
            });
        }

        Schema::table('volunteer_applications', function (Blueprint $table) {
            $table->unsignedBigInteger('id_volunteer_opportunity')->nullable()->after('id_user');
            
            $table->foreign('id_volunteer_opportunity', 'fk_vol_app_opp')
                  ->references('id_volunteer_opportunity')
                  ->on('volunteer_opportunities')
                  ->onDelete('set null'); 
        });
    }

    public function down(): void
    {
        Schema::table('volunteer_applications', function (Blueprint $table) {
            if (Schema::hasColumn('volunteer_applications', 'id_volunteer_opportunity')) {
                $table->dropForeign('fk_vol_app_opp');
                $table->dropColumn('id_volunteer_opportunity');
            }
        });
    }
};