<?php

namespace Database\Seeders;

use App\Models\Cv;
use App\Models\Experience;
use App\Models\User;
use Illuminate\Database\Seeder;

class ExperienceSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::where('email', 'stuartsmg7@gmail.com')->first();
        $cv = Cv::where('slug', 'stuart-smg-professional-cv')->first();

        if (!$user || !$cv) {
            return;
        }

        $experiences = [
            [
                'job_title' => 'Software Developer Intern',
                'company' => 'Imartgroup Ltd',
                'location' => 'Dar es Salaam, Tanzania',
                'start_date' => '2024-01-01',
                'end_date' => '2025-12-31',
                'is_current' => false,
                'description' => 'Worked on web and mobile application development using Laravel, PHP, Flutter and Android Studio.',
                'achievements' => 'Developed application features, worked with databases and APIs, and gained practical experience in software development.',
            ],
            [
                'job_title' => 'IT Student Developer',
                'company' => 'National Institute of Transport',
                'location' => 'Dar es Salaam, Tanzania',
                'start_date' => '2025-01-01',
                'end_date' => null,
                'is_current' => true,
                'description' => 'Developing academic and personal software projects while applying information technology concepts.',
                'achievements' => 'Built web applications, REST APIs and software systems using modern development technologies.',
            ],
        ];

        foreach ($experiences as $experience) {
            Experience::updateOrCreate(
                [
                    'user_id' => $user->id,
                    'cv_id' => $cv->id,
                    'job_title' => $experience['job_title'],
                    'company' => $experience['company'],
                ],
                [
                    'location' => $experience['location'],
                    'start_date' => $experience['start_date'],
                    'end_date' => $experience['end_date'],
                    'is_current' => $experience['is_current'],
                    'description' => $experience['description'],
                    'achievements' => $experience['achievements'],
                ]
            );
        }
    }
}