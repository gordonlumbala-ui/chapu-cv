<?php

namespace Database\Seeders;

use App\Models\Cv;
use App\Models\Education;
use App\Models\User;
use Illuminate\Database\Seeder;

class EducationSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::where('email', 'stuartsmg7@gmail.com')->first();
        $cv = Cv::where('slug', 'stuart-smg-professional-cv')->first();

        if (!$user || !$cv) {
            return;
        }

        Education::updateOrCreate(
            [
                'user_id' => $user->id,
                'cv_id' => $cv->id,
                'institution' => 'National Institute of Transport',
                'program' => 'Bachelor Degree',
            ],
            [
                'education_level' => 'Bachelor Degree',
                'field_of_study' => 'Information Technology',
                'start_date' => '2022-10-01',
                'end_date' => '2026-07-31',
                'grade' => 'GPA 3.3',
                'certificate' => 'Bachelor Degree in Information Technology',
                'description' => 'Bachelor degree studies in Information Technology with practical experience in software development and information systems.',
            ]
        );

        Education::updateOrCreate(
            [
                'user_id' => $user->id,
                'cv_id' => $cv->id,
                'institution' => 'Advanced Secondary School',
                'program' => 'Advanced Certificate of Secondary Education',
            ],
            [
                'education_level' => 'Advanced Secondary Education',
                'field_of_study' => 'General Studies',
                'start_date' => '2019-07-01',
                'end_date' => '2021-06-30',
                'grade' => 'Division II',
                'certificate' => 'ACSEE',
                'description' => 'Advanced secondary education.',
            ]
        );
    }
}