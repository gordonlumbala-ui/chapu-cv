<?php

namespace Database\Factories;

use App\Models\Cv;
use App\Models\CvTemplate;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CvFactory extends Factory
{
    protected $model = Cv::class;

    public function definition(): array
    {
        $title = fake()->name() . ' CV';

        return [
            'user_id' => User::factory(),
            'cv_template_id' => CvTemplate::factory(),
            'title' => $title,
            'slug' => Str::slug($title) . '-' . fake()->unique()->numberBetween(1000, 9999),
            'cv_type' => fake()->randomElement([
                'professional',
                'academic',
                'technical',
                'job',
                'custom',
            ]),
            'description' => fake()->sentence(),
            'is_default' => false,
            'is_public' => fake()->boolean(70),
            'is_active' => true,
        ];
    }
}