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

    /**
     * CV template.
     */
    public function template(): BelongsTo
    {
        return $this->belongsTo(CvTemplate::class, 'cv_template_id');
    }

    
    public function educations(): HasMany
    {
        return $this->hasMany(Education::class);
    }

   
    public function experiences(): HasMany
    {
        return $this->hasMany(Experience::class);
    }

  
    public function skills(): BelongsToMany
    {
        return $this->belongsToMany(Skill::class, 'cv_skills')
            ->withTimestamps();
    }

   
    public function projects(): HasMany
    {
        return $this->hasMany(Project::class);
    }

    public function certifications(): HasMany
    {
        return $this->hasMany(Certification::class);
    }


    public function languages(): HasMany
    {
        return $this->hasMany(Language::class);
    }


    public function references(): HasMany
    {
        return $this->hasMany(Reference::class);
    }

    /**
     * Social links.
     */
    public function socialLinks(): HasMany
    {
        return $this->hasMany(SocialLink::class);
    }

    public function sections(): HasMany
    {
        return $this->hasMany(CvSection::class);
    }

 
    public function publicProfiles(): HasMany
    {
        return $this->hasMany(PublicProfile::class);
    }

    public function qrCodes(): HasMany
    {
        return $this->hasMany(QRCode::class);
    }

 
    public function downloads(): HasMany
    {
        return $this->hasMany(CvDownload::class);
    }
}