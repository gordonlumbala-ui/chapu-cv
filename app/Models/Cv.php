<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Cv extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'cv_template_id',
        'title',
        'slug',
        'cv_type',
        'description',
        'is_default',
        'is_public',
        'is_active',
    ];

    protected $casts = [
        'is_default' => 'boolean',
        'is_public' => 'boolean',
        'is_active' => 'boolean',
    ];

    /**
     * The user who owns this CV.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function socialLinks(): HasMany
{
    return $this->hasMany(SocialLink::class);
}

    /**
     * CV template.
     */
    public function template(): BelongsTo
    {
        return $this->belongsTo(CvTemplate::class, 'cv_template_id');
    }

    /**
     * Education records.
     */
    public function educations(): HasMany
    {
        return $this->hasMany(Education::class);
    }

    /**
     * Experience records.
     */
    public function experiences(): HasMany
    {
        return $this->hasMany(Experience::class);
    }

    /**
     * Skills attached to this CV.
     */
    public function skills(): BelongsToMany
    {
        return $this->belongsToMany(Skill::class, 'cv_skills')
            ->withTimestamps();
    }

    /**
     * Projects.
     */
    public function projects(): HasMany
    {
        return $this->hasMany(Project::class);
    }

    /**
     * Certifications.
     */
    public function certifications(): HasMany
    {
        return $this->hasMany(Certification::class);
    }

    /**
     * Languages.
     */
    public function languages(): HasMany
    {
        return $this->hasMany(Language::class);
    }

    /**
     * References.
     */
    public function references(): HasMany
    {
        return $this->hasMany(Reference::class);
    }
}