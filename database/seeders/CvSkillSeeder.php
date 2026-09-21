<?php

namespace Database\Seeders;

use App\Models\Cv;
use App\Models\Skill;
use Illuminate\Database\Seeder;

class CvSkillSeeder extends Seeder
{
    public function run(): void
    {
        $cvs = Cv::where('is_active', true)->get();

        foreach ($cvs as $cv) {
            $skills = Skill::where('user_id', $cv->user_id)->get();

            if ($skills->isEmpty()) {
                continue;
            }

            $cv->skills()->syncWithoutDetaching(
                $skills->pluck('id')->toArray()
            );
        }
    }
}