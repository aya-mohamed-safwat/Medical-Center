<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('speciality_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('speciality_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('locale');
            $table->unique(['speciality_id', 'locale']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('speciality_translations');
    }
};
