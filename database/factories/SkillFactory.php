<?php

namespace Database\Factories;

use App\Models\Skill;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class SkillFactory extends Factory
{
    protected $model = Skill::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'name' => fake()->unique()->randomElement([
                'Communication',
                'Leadership',
                'Teamwork',
                'Time Management',
                'Problem Solving',
                'Critical Thinking',
                'Customer Service',
                'Project Management',
                'Public Speaking',
                'Decision Making',
                'Adaptability',
                'Creativity',
                'Organization',
                'Negotiation',
                'Research',
                'Report Writing',
                'Conflict Resolution',
                'Interpersonal Skills',
                'Planning',
                'Presentation Skills',
            ]),
            'category' => 'Professional',
            'level' => fake()->randomElement([
                'Beginner',
                'Intermediate',
                'Advanced',
            ]),
            'percentage' => fake()->numberBetween(50, 100),
        ];
    }
}