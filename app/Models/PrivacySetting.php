<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PrivacySetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'show_email',
        'show_phone',
        'show_address',
        'show_date_of_birth',
        'show_gender',
        'show_education',
        'show_experience',
        'show_skills',
        'show_projects',
        'show_certifications',
        'show_references',
    ];

    protected $casts = [
        'show_email' => 'boolean',
        'show_phone' => 'boolean',
        'show_address' => 'boolean',
        'show_date_of_birth' => 'boolean',
        'show_gender' => 'boolean',
        'show_education' => 'boolean',
        'show_experience' => 'boolean',
        'show_skills' => 'boolean',
        'show_projects' => 'boolean',
        'show_certifications' => 'boolean',
        'show_references' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}