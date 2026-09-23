<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone', 30)->nullable()->after('email');
            $table->string('professional_title', 150)->nullable()->after('phone');
            $table->text('summary')->nullable()->after('professional_title');
            $table->string('address')->nullable()->after('summary');
            $table->string('city', 100)->nullable()->after('address');
            $table->string('country', 100)->nullable()->after('city');
            $table->date('date_of_birth')->nullable()->after('country');
            $table->string('gender', 30)->nullable()->after('date_of_birth');
            $table->string('website')->nullable()->after('gender');
            $table->string('linkedin_url')->nullable()->after('website');
            $table->string('github_url')->nullable()->after('linkedin_url');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'phone',
                'professional_title',
                'summary',
                'address',
                'city',
                'country',
                'date_of_birth',
                'gender',
                'website',
                'linkedin_url',
                'github_url',
            ]);
        });
    }
};
