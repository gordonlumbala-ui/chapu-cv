<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('privacy_settings', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->boolean('show_email')->default(false);
            $table->boolean('show_phone')->default(false);
            $table->boolean('show_address')->default(false);
            $table->boolean('show_date_of_birth')->default(false);
            $table->boolean('show_gender')->default(false);

            $table->boolean('show_education')->default(true);
            $table->boolean('show_experience')->default(true);
            $table->boolean('show_skills')->default(true);
            $table->boolean('show_projects')->default(true);
            $table->boolean('show_certifications')->default(true);
            $table->boolean('show_references')->default(false);

            $table->timestamps();

            $table->unique('user_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('privacy_settings');
    }
};