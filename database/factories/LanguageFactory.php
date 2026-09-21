<?php

namespace Database\Factories;

use App\Models\Cv;
use App\Models\Language;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class LanguageFactory extends Factory
{
    protected $model = Language::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'cv_id' => Cv::factory(),
            'language' => fake()->randomElement([
                'English',
                'Swahili',
                'French',
                'Arabic',
                'Spanish',
                'German',
            ]),
            'proficiency' => fake()->randomElement([
                'Basic',
                'Intermediate',
                'Fluent',
                'Native',
            ]),
            'percentage' => fake()->numberBetween(30, 100),
        ];
    }
}