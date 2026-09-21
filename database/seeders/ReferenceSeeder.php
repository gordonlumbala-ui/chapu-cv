<?php

namespace Database\Seeders;

use App\Models\Cv;
use App\Models\Reference;
use App\Models\User;
use Illuminate\Database\Seeder;

class ReferenceSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::where('email', 'stuartsmg7@gmail.com')->first();
        $cv = Cv::where('slug', 'stuart-smg-professional-cv')->first();

        if (!$user || !$cv) {
            return;
        }

        $references = [
            [
                'name' => 'Godfrey Mwakajila',
                'position' => 'Professional Mentor',
                'organization' => 'Independent',
                'relationship' => 'Mentor',
                'email' => null,
                'phone' => null,
                'address' => 'Tanzania',
            ],
            [
                'name' => 'Imartgroup Supervisor',
                'position' => 'Software Development Supervisor',
                'organization' => 'Imartgroup Ltd',
                'relationship' => 'Work Supervisor',
                'email' => null,
                'phone' => null,
                'address' => 'Dar es Salaam, Tanzania',
            ],
            [
                'name' => 'Academic Supervisor',
                'position' => 'Lecturer',
                'organization' => 'National Institute of Transport',
                'relationship' => 'Academic Supervisor',
                'email' => null,
                'phone' => null,
                'address' => 'Dar es Salaam, Tanzania',
            ],
        ];

        foreach ($references as $reference) {
            Reference::updateOrCreate(
                [
                    'user_id' => $user->id,
                    'cv_id' => $cv->id,
                    'name' => $reference['name'],
                    'organization' => $reference['organization'],
                ],
                [
                    'position' => $reference['position'],
                    'relationship' => $reference['relationship'],
                    'email' => $reference['email'],
                    'phone' => $reference['phone'],
                    'address' => $reference['address'],
                ]
            );
        }
    }
}