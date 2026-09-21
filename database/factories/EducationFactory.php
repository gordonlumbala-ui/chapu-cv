<?php

namespace Database\Factories;

use App\Models\Education;
use App\Models\User;
use App\Models\Cv;
use Illuminate\Database\Eloquent\Factories\Factory;

class EducationFactory extends Factory
{
    protected $model = Education::class;

    public function definition(): array
    {
        $startDate = fake()->dateTimeBetween('-8 years', '-2 years');
        $endDate = fake()->dateTimeBetween($startDate, 'now');

        return [
            'user_id' => User::factory(),
            'cv_id' => Cv::factory(),
            'education_level' => fake()->randomElement([
                'Certificate',
                'Diploma',
                'Bachelor Degree',
                'Master Degree',
                'PhD',
            ]),
            'institution' => fake()->company(),
            'program' => fake()->jobTitle(),
            'field_of_study' => fake()->randomElement([
                'Information Technology',
                'Computer Science',
                'Business Administration',
                'Accounting',
                'Engineering',
                'Education',
            ]),
            'start_date' => $startDate,
            'end_date' => $endDate,
            'grade' => fake()->randomElement([
                'GPA 3.2',
                'GPA 3.5',
                'GPA 3.8',
                'Division I',
                'Division II',
            ]),
            'certificate' => fake()->word() . ' Certificate',
            'description' => fake()->sentence(),
        ];
    }
}