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
        Schema::create('doctor_profile_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('doctor_profile_id')->constrained()->onDelete('cascade');
            $table->text('bio')->nullable();
            $table->string('gender');
            $table->string('locale');
            $table->unique(['doctor_profile_id', 'locale']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doctor_profile_translations');
    }
};
