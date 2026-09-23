<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;

    /** @use HasFactory<UserFactory> */
    use HasFactory;

    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'is_active',
        'phone',
        'professional_title',
        'summary',
        'address',
        'city',
        'country',
        'date_of_birth',
        'gender',
        'website',
        'linkedin_url',
        'github_url',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];


    public function cvs()
{
    return $this->hasMany(Cv::class);
}

public function educations()
{
    return $this->hasMany(Education::class);
}

public function experiences()
{
    return $this->hasMany(Experience::class);
}

public function skills()
{
    return $this->hasMany(Skill::class);
}

public function projects()
{
    return $this->hasMany(Project::class);
}

public function certifications()
{
    return $this->hasMany(Certification::class);
}

public function languages()
{
    return $this->hasMany(Language::class);
}

public function references()
{
    return $this->hasMany(Reference::class);
}

public function socialLinks()
{
    return $this->hasMany(SocialLink::class);
}

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'date_of_birth' => 'date',
            'is_active' => 'boolean',
        ];
    }
}