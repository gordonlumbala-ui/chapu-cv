<?php

namespace Database\Seeders;

use App\Models\PrivacySetting;
use App\Models\User;
use Illuminate\Database\Seeder;

class PrivacySettingSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::whereIn('role', ['client', 'guest'])->get();

        foreach ($users as $user) {
            PrivacySetting::updateOrCreate(
                [
                    'user_id' => $user->id,
                ],
                [
                    'show_email' => false,
                    'show_phone' => false,
                    'show_address' => false,
                    'show_date_of_birth' => false,
                    'show_gender' => false,
                    'show_education' => true,
                    'show_experience' => true,
                    'show_skills' => true,
                    'show_projects' => true,
                    'show_certifications' => true,
                    'show_references' => false,
                ]
            );
        }
    }
}