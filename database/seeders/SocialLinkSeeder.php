<?php

namespace Database\Seeders;

use App\Models\Cv;
use App\Models\SocialLink;
use App\Models\User;
use Illuminate\Database\Seeder;

class SocialLinkSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::where('email', 'stuartsmg7@gmail.com')->first();
        $cv = Cv::where('slug', 'stuart-smg-professional-cv')->first();

        if (!$user || !$cv) {
            return;
        }

        $socialLinks = [
            [
                'platform' => 'GitHub',
                'username' => 'Stuart-SMG',
                'url' => 'https://github.com/Stuart-SMG',
                'display_order' => 1,
                'is_visible' => true,
            ],
            [
                'platform' => 'LinkedIn',
                'username' => 'Stuart SMG',
                'url' => null,
                'display_order' => 2,
                'is_visible' => true,
            ],
            [
                'platform' => 'Instagram',
                'username' => 'Stuart SMG',
                'url' => null,
                'display_order' => 3,
                'is_visible' => true,
            ],
        ];

        foreach ($socialLinks as $socialLink) {
            SocialLink::updateOrCreate(
                [
                    'user_id' => $user->id,
                    'cv_id' => $cv->id,
                    'platform' => $socialLink['platform'],
                ],
                [
                    'username' => $socialLink['username'],
                    'url' => $socialLink['url'],
                    'display_order' => $socialLink['display_order'],
                    'is_visible' => $socialLink['is_visible'],
                ]
            );
        }
    }
}