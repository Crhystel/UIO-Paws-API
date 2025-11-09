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
        Schema::create('home_information', function (Blueprint $table) {
            $table->bigIncrements('id_home_info');
            $table->foreignId('id_adoption_application')->constrained(table: 'adoption_applications', column: 'id_adoption_application')->onDelete('cascade');
            $table->string('dwelling_type');
            $table->boolean('has_yard');
            $table->string('yard_enclosure_type')->nullable();
            $table->string('wall_material');
            $table->string('floor_material');
            $table->integer('room_count');
            $table->integer('bathroom_count');
            $table->integer('adults_in_home');
            $table->boolean('has_balcony');
            $table->integer('current_pet_count');
            $table->text('others_pets_description')->nullable();
            $table->boolean('all_members_agree');
            $table->text('previous_pets_history')->nullable();
            $table->text('motivation_for_adoption');
            $table->integer('hours_pet_will_be_alone');
            $table->text('location_when_alone');
            $table->text('exercise_plan');
            $table->text('vacation_emergency_plan');
            $table->text('behavioral_issue_plan');
            $table->string('vet_reference_name')->nullable();
            $table->string('vet_reference_phone')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('home_information');
    }
};
