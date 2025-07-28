<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('static_page_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('static_page_id')->constrained()->onDelete('cascade');
            $table->string('title');
            $table->string('locale');
            $table->text('content');
            $table->unique(['static_page_id', 'locale']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('static_page_translations');
    }
};
