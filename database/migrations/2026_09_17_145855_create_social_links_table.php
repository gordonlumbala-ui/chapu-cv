<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('social_links', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('cv_id')
                ->nullable()
                ->constrained('cvs')
                ->cascadeOnDelete();

            $table->string('platform');
            $table->string('username')->nullable();
            $table->string('url');

            $table->unsignedInteger('display_order')->default(0);
            $table->boolean('is_visible')->default(true);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('social_links');
    }
};