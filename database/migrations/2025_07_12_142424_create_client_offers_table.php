<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('client_offers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_profile_id')->constrained()->onDelete('cascade');
            $table->foreignId('offer_id')->constrained()->onDelete('cascade');
            $table->foreignId('appointment_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('status')->default('valid');
            $table->boolean('is_paid')->default(false);
            $table->integer('remaining_sessions');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('client_offers');
    }
};
