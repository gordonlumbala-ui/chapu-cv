<?php

namespace Database\Seeders;

use App\Models\QRCode;
use App\Models\QrScan;
use Illuminate\Database\Seeder;

class QrScanSeeder extends Seeder
{
    public function run(): void
    {
        $qrCodes = QRCode::where('is_active', true)->get();

        foreach ($qrCodes as $qrCode) {
            $scans = [
                [
                    'ip_address' => '192.168.1.80',
                    'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64)',
                    'device_type' => 'Desktop',
                    'browser' => 'Chrome',
                    'platform' => 'Windows',
                    'scanned_at' => now()->subDays(6),
                ],
                [
                    'ip_address' => '192.168.1.90',
                    'user_agent' => 'Mozilla/5.0 (Linux; Android 13)',
                    'device_type' => 'Mobile',
                    'browser' => 'Chrome',
                    'platform' => 'Android',
                    'scanned_at' => now()->subDays(3),
                ],
                [
                    'ip_address' => '192.168.1.100',
                    'user_agent' => 'Mozilla/5.0 (iPhone; CPU iPhone OS 17_0 like Mac OS X)',
                    'device_type' => 'Mobile',
                    'browser' => 'Safari',
                    'platform' => 'iOS',
                    'scanned_at' => now()->subDay(),
                ],
            ];

            foreach ($scans as $scan) {
                QrScan::firstOrCreate(
                    [
                        'qrcode_id' => $qrCode->id,
                        'ip_address' => $scan['ip_address'],
                        'scanned_at' => $scan['scanned_at'],
                    ],
                    [
                        'user_id' => null,
                        'user_agent' => $scan['user_agent'],
                        'device_type' => $scan['device_type'],
                        'browser' => $scan['browser'],
                        'platform' => $scan['platform'],
                    ]
                );
            }
        }
    }
}