<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cv_sections', function (Blueprint $table) {
            $table->id();

            $table->foreignId('cv_id')
                ->constrained('cvs')
                ->cascadeOnDelete();

            $table->string('section_type');
            $table->string('title')->nullable();

            $table->unsignedInteger('display_order')->default(0);
            $table->boolean('is_visible')->default(true);

            $table->timestamps();

            $table->unique(['cv_id', 'section_type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cv_sections');
    }
};