<?php

namespace Database\Seeders;

use App\Models\ProfileView;
use App\Models\PublicProfile;
use Illuminate\Database\Seeder;

class ProfileViewSeeder extends Seeder
{
    public function run(): void
    {
        $profiles = PublicProfile::where('is_active', true)->get();

        foreach ($profiles as $profile) {
            $views = [
                [
                    'ip_address' => '192.168.1.40',
                    'user_agent' => 'Mozilla/5.0',
                    'viewed_at' => now()->subDays(7),
                ],
                [
                    'ip_address' => '192.168.1.50',
                    'user_agent' => 'Mozilla/5.0',
                    'viewed_at' => now()->subDays(4),
                ],
                [
                    'ip_address' => '192.168.1.60',
                    'user_agent' => 'Mozilla/5.0',
                    'viewed_at' => now()->subDay(),
                ],
                [
                    'ip_address' => '192.168.1.70',
                    'user_agent' => 'Mozilla/5.0',
                    'viewed_at' => now(),
                ],
            ];

            foreach ($views as $view) {
                ProfileView::firstOrCreate(
                    [
                        'public_profile_id' => $profile->id,
                        'ip_address' => $view['ip_address'],
                        'viewed_at' => $view['viewed_at'],
                    ],
                    [
                        'user_id' => null,
                        'user_agent' => $view['user_agent'],
                    ]
                );
            }
        }
    }
}