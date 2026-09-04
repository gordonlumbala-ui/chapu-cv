<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('qrcodes', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('cv_id')
                ->nullable()
                ->constrained('cvs')
                ->nullOnDelete();

            $table->foreignId('public_profile_id')
                ->nullable()
                ->constrained('public_profiles')
                ->nullOnDelete();

            $table->string('name')->nullable();
            $table->string('token')->unique();
            $table->string('file_path')->nullable();

            $table->boolean('is_active')->default(true);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('qrcodes');
    }
};