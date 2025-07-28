<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('doctor_profile_id')->constrained('doctor_profiles')->onDelete('cascade');
            $table->foreignId('client_profile_id')->constrained()->onDelete('cascade');
            $table->foreignId('service_id')->constrained('services')->onDelete('cascade');
            $table->foreignId('speciality_id')->constrained('specialities')->onDelete('cascade');
            $table->foreignId('offer_id')->nullable()->constrained('offers')->onDelete('cascade');
            $table->date('date');
            $table->time('time');
            $table->integer('price');
            $table->string('duration');
            $table->string('status')->default('pending');
            $table->text('note')->nullable();
            $table->timestamp('canceled_at')->nullable();
            $table->string('canceled_by')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
