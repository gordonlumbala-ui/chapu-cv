<?php

namespace Database\Seeders;

use App\Models\Skill;
use App\Models\User;
use Illuminate\Database\Seeder;

class SkillSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::whereIn('email', [
            'stuartsmg7@gmail.com',
            'client@chapcv.com',
        ])->get();

        $skills = [
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
        ];

        foreach ($users as $user) {
            foreach ($skills as $index => $skill) {
                Skill::updateOrCreate(
                    [
                        'user_id' => $user->id,
                        'name' => $skill,
                    ],
                    [
                        'category' => 'Professional',
                        'level' => match (true) {
                            $index < 5 => 'Advanced',
                            $index < 12 => 'Intermediate',
                            default => 'Beginner',
                        },
                        'percentage' => match (true) {
                            $index < 5 => 85,
                            $index < 12 => 75,
                            default => 65,
                        },
                    ]
                );
            }
        }
    }
}