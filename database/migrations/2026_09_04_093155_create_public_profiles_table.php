<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('public_profiles', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('cv_id')
                ->nullable()
                ->constrained('cvs')
                ->nullOnDelete();

            $table->string('slug')->unique();

            $table->string('title')->nullable();
            $table->text('description')->nullable();

            $table->boolean('is_active')->default(true);
            $table->timestamp('published_at')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('public_profiles');
    }
};