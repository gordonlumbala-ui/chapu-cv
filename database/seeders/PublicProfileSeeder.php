<?php

namespace Database\Seeders;

use App\Models\Cv;
use App\Models\PublicProfile;
use App\Models\User;
use Illuminate\Database\Seeder;

class PublicProfileSeeder extends Seeder
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

            PublicProfile::updateOrCreate(
                [
                    'cv_id' => $cv->id,
                ],
                [
                    'user_id' => $user->id,
                    'slug' => $cv->slug,
                    'title' => $cv->title,
                    'description' => $cv->description,
                    'is_active' => true,
                    'published_at' => now(),
                ]
            );
        }
    }
}