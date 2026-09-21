<?php

namespace Database\Factories;

use App\Models\CvTemplate;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CvTemplateFactory extends Factory
{
    protected $model = CvTemplate::class;

    public function definition(): array
    {
        $name = fake()->unique()->words(2, true);

        return [
            'name' => ucwords($name),
            'slug' => Str::slug($name),
            'description' => fake()->sentence(),
            'preview_image' => null,
            'template_path' => 'cv.templates.' . Str::slug($name),
            'is_active' => true,
            'is_premium' => false,
        ];
    }
}