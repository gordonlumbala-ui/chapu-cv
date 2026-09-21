<?php

namespace Database\Seeders;

use App\Models\Cv;
use App\Models\CvTemplate;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CvSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::where('role', 'client')->get();
        $templates = CvTemplate::where('is_active', true)->get();

        if ($users->isEmpty() || $templates->isEmpty()) {
            return;
        }

        $cvs = [
            [
                'user_email' => 'stuartsmg7@gmail.com',
                'template_slug' => 'professional',
                'title' => 'Stuart SMG - Professional CV',
                'cv_type' => 'professional',
                'description' => 'Professional CV for software development and information technology opportunities.',
                'is_default' => true,
                'is_public' => true,
                'is_active' => true,
            ],
            [
                'user_email' => 'client@chapcv.com',
                'template_slug' => 'modern',
                'title' => 'Chapu Client - Modern CV',
                'cv_type' => 'professional',
                'description' => 'Modern professional CV profile.',
                'is_default' => true,
                'is_public' => true,
                'is_active' => true,
            ],
            [
                'user_email' => 'client@chapcv.com',
                'template_slug' => 'classic',
                'title' => 'Chapu Client - Academic CV',
                'cv_type' => 'academic',
                'description' => 'Academic CV for education and research opportunities.',
                'is_default' => false,
                'is_public' => false,
                'is_active' => true,
            ],
        ];

        foreach ($cvs as $data) {
            $user = $users->firstWhere('email', $data['user_email']);
            $template = $templates->firstWhere('slug', $data['template_slug']);

            if (!$user || !$template) {
                continue;
            }

            Cv::updateOrCreate(
                [
                    'user_id' => $user->id,
                    'slug' => Str::slug($data['title']),
                ],
                [
                    'cv_template_id' => $template->id,
                    'title' => $data['title'],
                    'cv_type' => $data['cv_type'],
                    'description' => $data['description'],
                    'is_default' => $data['is_default'],
                    'is_public' => $data['is_public'],
                    'is_active' => $data['is_active'],
                ]
            );
        }
    }
}