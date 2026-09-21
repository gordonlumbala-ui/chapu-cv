<?php

namespace Database\Seeders;

use App\Models\Cv;
use App\Models\CvSection;
use Illuminate\Database\Seeder;

class CvSectionSeeder extends Seeder
{
    public function run(): void
    {
        $cvs = Cv::all();

        foreach ($cvs as $cv) {
            $sections = [
                [
                    'section_type' => 'profile',
                    'title' => 'Profile',
                    'display_order' => 1,
                    'is_visible' => true,
                ],
                [
                    'section_type' => 'education',
                    'title' => 'Education',
                    'display_order' => 2,
                    'is_visible' => true,
                ],
                [
                    'section_type' => 'experience',
                    'title' => 'Experience',
                    'display_order' => 3,
                    'is_visible' => true,
                ],
                [
                    'section_type' => 'skills',
                    'title' => 'Skills',
                    'display_order' => 4,
                    'is_visible' => true,
                ],
                [
                    'section_type' => 'projects',
                    'title' => 'Projects',
                    'display_order' => 5,
                    'is_visible' => true,
                ],
                [
                    'section_type' => 'certifications',
                    'title' => 'Certifications',
                    'display_order' => 6,
                    'is_visible' => true,
                ],
                [
                    'section_type' => 'languages',
                    'title' => 'Languages',
                    'display_order' => 7,
                    'is_visible' => true,
                ],
                [
                    'section_type' => 'references',
                    'title' => 'References',
                    'display_order' => 8,
                    'is_visible' => true,
                ],
            ];

            foreach ($sections as $section) {
                CvSection::updateOrCreate(
                    [
                        'cv_id' => $cv->id,
                        'section_type' => $section['section_type'],
                    ],
                    [
                        'title' => $section['title'],
                        'display_order' => $section['display_order'],
                        'is_visible' => $section['is_visible'],
                    ]
                );
            }
        }
    }
}