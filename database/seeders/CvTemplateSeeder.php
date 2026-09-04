<?php

namespace Database\Seeders;

use App\Models\CvTemplate;
use Illuminate\Database\Seeder;

class CvTemplateSeeder extends Seeder
{
    public function run(): void
    {
        $templates = [
            [
                'name' => 'Professional',
                'slug' => 'professional',
                'description' => 'Clean and professional CV template suitable for most careers.',
                'preview_image' => null,
                'template_path' => 'cv.templates.professional',
                'is_active' => true,
                'is_premium' => false,
            ],
            [
                'name' => 'Modern',
                'slug' => 'modern',
                'description' => 'Modern CV template with a clean layout for creative and technical professionals.',
                'preview_image' => null,
                'template_path' => 'cv.templates.modern',
                'is_active' => true,
                'is_premium' => false,
            ],
            [
                'name' => 'Classic',
                'slug' => 'classic',
                'description' => 'Simple traditional CV template suitable for formal applications.',
                'preview_image' => null,
                'template_path' => 'cv.templates.classic',
                'is_active' => true,
                'is_premium' => false,
            ],
        ];

        foreach ($templates as $template) {
            CvTemplate::updateOrCreate(
                ['slug' => $template['slug']],
                $template
            );
        }
    }
}