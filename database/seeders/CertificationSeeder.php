<?php

namespace Database\Seeders;

use App\Models\Certification;
use App\Models\Cv;
use App\Models\User;
use Illuminate\Database\Seeder;

class CertificationSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::where('email', 'stuartsmg7@gmail.com')->first();
        $cv = Cv::where('slug', 'stuart-smg-professional-cv')->first();

        if (!$user || !$cv) {
            return;
        }

        $certifications = [
            [
                'name' => 'Certificate in Computer Applications',
                'issuing_organization' => 'Information Technology Training Institute',
                'credential_id' => null,
                'credential_url' => null,
                'issue_date' => '2022-06-01',
                'expiry_date' => null,
                'does_not_expire' => true,
                'description' => 'Certificate covering fundamental computer applications and digital skills.',
            ],
            [
                'name' => 'Web Development Certificate',
                'issuing_organization' => 'Professional Training Institute',
                'credential_id' => null,
                'credential_url' => null,
                'issue_date' => '2023-08-01',
                'expiry_date' => null,
                'does_not_expire' => true,
                'description' => 'Certificate covering web development fundamentals and practical application development.',
            ],
            [
                'name' => 'Database Management Certificate',
                'issuing_organization' => 'Professional Training Institute',
                'credential_id' => null,
                'credential_url' => null,
                'issue_date' => '2024-03-01',
                'expiry_date' => null,
                'does_not_expire' => true,
                'description' => 'Certificate covering database concepts, management and practical database operations.',
            ],
        ];

        foreach ($certifications as $certification) {
            Certification::updateOrCreate(
                [
                    'user_id' => $user->id,
                    'cv_id' => $cv->id,
                    'name' => $certification['name'],
                ],
                [
                    'issuing_organization' => $certification['issuing_organization'],
                    'credential_id' => $certification['credential_id'],
                    'credential_url' => $certification['credential_url'],
                    'issue_date' => $certification['issue_date'],
                    'expiry_date' => $certification['expiry_date'],
                    'does_not_expire' => $certification['does_not_expire'],
                    'description' => $certification['description'],
                ]
            );
        }
    }
}