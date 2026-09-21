<?php

namespace Database\Factories;

use App\Models\Certification;
use App\Models\Cv;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CertificationFactory extends Factory
{
    protected $model = Certification::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'cv_id' => Cv::factory(),
            'name' => fake()->randomElement([
                'Web Development Certificate',
                'Database Management Certificate',
                'Computer Applications Certificate',
                'Project Management Certificate',
                'Digital Skills Certificate',
            ]),
            'issuing_organization' => fake()->company(),
            'credential_id' => fake()->optional()->bothify('CERT-####-????'),
            'credential_url' => fake()->optional()->url(),
            'issue_date' => fake()->dateTimeBetween('-5 years', 'now'),
            'expiry_date' => null,
            'does_not_expire' => true,
            'description' => fake()->sentence(),
        ];
    }
}