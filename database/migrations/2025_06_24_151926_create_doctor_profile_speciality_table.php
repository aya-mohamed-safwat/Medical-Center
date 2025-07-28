<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('doctor_profile_speciality', function (Blueprint $table) {
            $table->id();
            $table->foreignId('doctor_profile_id')->references('id')->on('doctor_profiles')->onDelete('cascade');
            $table->foreignId('speciality_id')->constrained('specialities')->onDelete('cascade');
            $table->unique(['doctor_profile_id', 'speciality_id']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('doctor_profile_speciality');
    }
};
