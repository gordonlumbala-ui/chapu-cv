<?php

namespace Database\Seeders;

use App\Models\Cv;
use App\Models\PublicProfile;
use App\Models\QRCode;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class QRCodeSeeder extends Seeder
{
    public function run(): void
    {
        $profiles = PublicProfile::where('is_active', true)->get();

        foreach ($profiles as $profile) {
            $cv = Cv::find($profile->cv_id);
            $user = User::find($profile->user_id);

            if (!$cv || !$user) {
                continue;
            }

            QRCode::updateOrCreate(
                [
                    'cv_id' => $cv->id,
                    'public_profile_id' => $profile->id,
                ],
                [
                    'user_id' => $user->id,
                    'name' => $cv->title . ' QR Code',
                    'token' => Str::uuid()->toString(),
                    'file_path' => null,
                    'is_active' => true,
                ]
            );
        }
    }
}