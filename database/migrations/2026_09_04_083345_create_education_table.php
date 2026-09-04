<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('educations', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('education_level');
            $table->string('institution');
            $table->string('program')->nullable();
            $table->string('field_of_study')->nullable();

            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();

            $table->string('grade')->nullable();
            $table->string('certificate')->nullable();
            $table->text('description')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('educations');
    }
};