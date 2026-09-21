<?php

namespace Database\Seeders;

use App\Models\Cv;
use App\Models\CvDownload;
use App\Models\User;
use Illuminate\Database\Seeder;

class CvDownloadSeeder extends Seeder
{
    public function run(): void
    {
        $cvs = Cv::where('is_public', true)
            ->where('is_active', true)
            ->get();

        foreach ($cvs as $cv) {
            $user = User::find($cv->user_id);

            if (!$user) {
                continue;
            }

            $downloads = [
                [
                    'ip_address' => '192.168.1.10',
                    'user_agent' => 'Mozilla/5.0',
                    'downloaded_at' => now()->subDays(5),
                ],
                [
                    'ip_address' => '192.168.1.20',
                    'user_agent' => 'Mozilla/5.0',
                    'downloaded_at' => now()->subDays(3),
                ],
                [
                    'ip_address' => '192.168.1.30',
                    'user_agent' => 'Mozilla/5.0',
                    'downloaded_at' => now()->subDay(),
                ],
            ];

            foreach ($downloads as $download) {
                CvDownload::firstOrCreate(
                    [
                        'cv_id' => $cv->id,
                        'ip_address' => $download['ip_address'],
                        'downloaded_at' => $download['downloaded_at'],
                    ],
                    [
                        'user_id' => null,
                        'user_agent' => $download['user_agent'],
                    ]
                );
            }
        }
    }
}