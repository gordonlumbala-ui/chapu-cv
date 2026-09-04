<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $password = Hash::make('12345678');

        $users = [
            [
                'name' => 'Stuart SMG',
                'email' => 'stuartsmg7@gmail.com',
                'role' => 'client',
            ],
            [
                'name' => 'Chapu Client',
                'email' => 'client@chapcv.com',
                'role' => 'client',
            ],
            [
                'name' => 'Chapu Admin',
                'email' => 'admin@chapcv.com',
                'role' => 'admin',
            ],
            [
                'name' => 'Chapu Administrator',
                'email' => 'administrator@chapcv.com',
                'role' => 'admin',
            ],
            [
                'name' => 'Chapu Guest',
                'email' => 'guest@chapcv.com',
                'role' => 'guest',
            ],
            [
                'name' => 'Chapu Visitor',
                'email' => 'visitor@chapcv.com',
                'role' => 'guest',
            ],
        ];

        foreach ($users as $user) {
            User::updateOrCreate(
                ['email' => $user['email']],
                [
                    'name' => $user['name'],
                    'password' => $password,
                    'role' => $user['role'],
                    'is_active' => true,
                    'email_verified_at' => now(),
                ]
            );
        }
    }
}
