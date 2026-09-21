<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    protected static ?string $password;

    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'two_factor_secret' => null,
            'two_factor_recovery_codes' => null,
            'two_factor_confirmed_at' => null,
            'remember_token' => Str::random(10),
            'role' => 'client',
            'is_active' => true,
            'profile_photo_path' => null,
        ];
    }

    public function admin(): static
    {
        return $this->state([
            'role' => 'admin',
        ]);
    }

    public function guest(): static
    {
        return $this->state([
            'role' => 'guest',
        ]);
    }

    public function inactive(): static
    {
        return $this->state([
            'is_active' => false,
        ]);
    }

    public function unverified(): static
    {
        return $this->state([
            'email_verified_at' => null,
        ]);
    }
}