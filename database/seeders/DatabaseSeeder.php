<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{public function run(): void
{
    $this->call([
        UserSeeder::class,
        CvTemplateSeeder::class,
        CvSeeder::class,
        EducationSeeder::class,
        ExperienceSeeder::class,
        SkillSeeder::class,
        ProjectSeeder::class,
        CertificationSeeder::class,
        LanguageSeeder::class,
        ReferenceSeeder::class,
        SocialLinkSeeder::class,
        CvSectionSeeder::class,
        PrivacySettingSeeder::class,
        PublicProfileSeeder::class,
        QRCodeSeeder::class,
        CvDownloadSeeder::class,
        ProfileViewSeeder::class,
        QrScanSeeder::class,
        CvSkillSeeder::class,
    ]);
}
}