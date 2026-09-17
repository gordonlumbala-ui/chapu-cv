<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cvs', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('cv_template_id')
                ->nullable()
                ->constrained('cv_templates')
                ->nullOnDelete();

            $table->string('title');
            $table->string('slug')->unique();

            $table->string('cv_type')->default('professional');
            $table->text('description')->nullable();

            $table->boolean('is_default')->default(false);
            $table->boolean('is_public')->default(false);
            $table->boolean('is_active')->default(true);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cvs');
    }
};