<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('offers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('speciality_id')->constrained()->onDelete('cascade');
            $table->foreignId('service_id')->constrained()->onDelete('cascade');
            $table->enum('discount_type', ['percentage', 'fixed']);
            $table->decimal('discount_value', 8, 2)->default(0.00);
            $table->integer('original_price');

            $table->integer('number_of_reservation')->default(0);
            $table->integer('total_reservation')->default(1);
            $table->integer('max_reservation_per_user')->default(1);
            $table->integer('sessions_number');
            $table->integer('payment_timeout');

            $table->dateTime('start_time');
            $table->dateTime('end_time');

            $table->string('redirect_type')->nullable();
            $table->integer('redirect_id')->nullable();

            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('offers');
    }
};
