<?php

namespace Database\Seeders;

use App\Models\Cv;
use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::where('email', 'stuartsmg7@gmail.com')->first();
        $cv = Cv::where('slug', 'stuart-smg-professional-cv')->first();

        if (!$user || !$cv) {
            return;
        }

        $projects = [
            [
                'name' => 'Community Garden Management System',
                'role' => 'System Developer',
                'description' => 'A digital system for managing garden activities, crops, workers, tasks and garden resources.',
                'technologies' => 'Web Application, Database, REST API',
                'url' => null,
                'github_url' => null,
                'start_date' => '2025-01-01',
                'end_date' => '2025-08-31',
                'is_current' => false,
                'display_order' => 1,
            ],
            [
                'name' => 'Digital Career Profile and CV Builder',
                'role' => 'Developer',
                'description' => 'A platform that allows users to create, manage and publish professional CVs and career profiles.',
                'technologies' => 'Laravel, MySQL, Livewire',
                'url' => null,
                'github_url' => null,
                'start_date' => '2026-01-01',
                'end_date' => null,
                'is_current' => true,
                'display_order' => 2,
            ],
            [
                'name' => 'Church Management System',
                'role' => 'System Developer',
                'description' => 'A management system designed to organize church members, activities and administrative information.',
                'technologies' => 'Laravel, MySQL, Web Application',
                'url' => null,
                'github_url' => null,
                'start_date' => '2025-06-01',
                'end_date' => '2025-12-31',
                'is_current' => false,
                'display_order' => 3,
            ],
        ];

        foreach ($projects as $project) {
            Project::updateOrCreate(
                [
                    'user_id' => $user->id,
                    'cv_id' => $cv->id,
                    'name' => $project['name'],
                ],
                [
                    'role' => $project['role'],
                    'description' => $project['description'],
                    'technologies' => $project['technologies'],
                    'url' => $project['url'],
                    'github_url' => $project['github_url'],
                    'start_date' => $project['start_date'],
                    'end_date' => $project['end_date'],
                    'is_current' => $project['is_current'],
                    'display_order' => $project['display_order'],
                ]
            );
        }
    }
}