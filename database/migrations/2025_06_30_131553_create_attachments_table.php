<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('attachments', function (Blueprint $table) {
            $table->id();
            $table->string('original_name');
            $table->string('file_name');
            $table->string('file_type')->nullable();
            $table->integer('size');
            $table->string('file_path');
            $table->string('extension')->nullable();
            $table->integer('uploaded_by_id')->nullable();
            $table->string('uploaded_by_type')->nullable();
            $table->integer('fileable_id');
            $table->string('fileable_type');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('attachments');
    }
};
