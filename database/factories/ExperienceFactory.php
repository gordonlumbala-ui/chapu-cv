<?php

namespace Database\Factories;

use App\Models\Experience;
use App\Models\User;
use App\Models\Cv;
use Illuminate\Database\Eloquent\Factories\Factory;

class ExperienceFactory extends Factory
{
    protected $model = Experience::class;

    public function definition(): array
    {
        $startDate = fake()->dateTimeBetween('-8 years', '-1 year');

        return [
            'user_id' => User::factory(),
            'cv_id' => Cv::factory(),
            'job_title' => fake()->jobTitle(),
            'company' => fake()->company(),
            'location' => fake()->city() . ', Tanzania',
            'start_date' => $startDate,
            'end_date' => fake()->dateTimeBetween($startDate, 'now'),
            'is_current' => false,
            'description' => fake()->paragraph(),
            'achievements' => fake()->sentence(),
        ];
    }

    public function current(): static
    {
        return $this->state([
            'end_date' => null,
            'is_current' => true,
        ]);
    }
}