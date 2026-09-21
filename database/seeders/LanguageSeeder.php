<?php

namespace Database\Seeders;

use App\Models\Cv;
use App\Models\Language;
use App\Models\User;
use Illuminate\Database\Seeder;

class LanguageSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::where('email', 'stuartsmg7@gmail.com')->first();
        $cv = Cv::where('slug', 'stuart-smg-professional-cv')->first();

        if (!$user || !$cv) {
            return;
        }

        $languages = [
            [
                'language' => 'English',
                'proficiency' => 'Fluent',
                'percentage' => 90,
            ],
            [
                'language' => 'Swahili',
                'proficiency' => 'Native',
                'percentage' => 100,
            ],
            [
                'language' => 'Arabic',
                'proficiency' => 'Basic',
                'percentage' => 40,
            ],
        ];

        foreach ($languages as $language) {
            Language::updateOrCreate(
                [
                    'user_id' => $user->id,
                    'cv_id' => $cv->id,
                    'language' => $language['language'],
                ],
                [
                    'proficiency' => $language['proficiency'],
                    'percentage' => $language['percentage'],
                ]
            );
        }
    }
}