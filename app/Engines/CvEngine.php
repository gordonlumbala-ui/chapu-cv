<?php

namespace App\Engines;

use App\Engines\Concerns\OwnsResource;
use App\Models\Cv;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class CvEngine
{
    use OwnsResource;

    public const TYPES = [
        'professional',
        'academic',
        'technical',
        'job',
        'custom',
        'student',
        'graduate',
        'creative',
        'internship',
        'international',
    ];

    public function listFor(User $user): Collection
    {
        return $user->cvs()->with('template')->latest()->get();
    }

    public function findFor(User $user, Cv $cv): Cv
    {
        $this->ensureOwnedBy($cv, $user, 'CV not found.');
        $cv->load('template');

        return $cv;
    }

    public function findWithSections(User $user, Cv $cv): Cv
    {
        $this->ensureOwnedBy($cv, $user, 'CV not found.');

        $cv->load([
            'template',
            'educations',
            'experiences',
            'skills',
            'projects',
            'certifications',
            'languages',
            'references',
        ]);

        return $cv;
    }

    public function create(User $user, array $data): Cv
    {
        $validated = validator($data, $this->storeRules())->validate();

        if (! empty($validated['is_default'])) {
            $user->cvs()->update(['is_default' => false]);
        }

        $cv = $user->cvs()->create([
            'cv_template_id' => $validated['cv_template_id'] ?? null,
            'title' => $validated['title'],
            'slug' => $this->uniqueSlug($validated['title']),
            'cv_type' => $validated['cv_type'],
            'description' => $validated['description'] ?? null,
            'is_default' => (bool) ($validated['is_default'] ?? false),
            'is_public' => (bool) ($validated['is_public'] ?? false),
            'is_active' => true,
        ]);

        return $cv->load('template');
    }

    public function update(User $user, Cv $cv, array $data): Cv
    {
        $this->ensureOwnedBy($cv, $user, 'CV not found.');
        $validated = validator($data, $this->updateRules())->validate();

        if (($validated['is_default'] ?? false) === true) {
            $user->cvs()->whereKeyNot($cv->id)->update(['is_default' => false]);
        }

        if (isset($validated['title']) && $validated['title'] !== $cv->title) {
            $validated['slug'] = $this->uniqueSlug($validated['title'], $cv->id);
        }

        $cv->update($validated);

        return $cv->fresh()->load('template');
    }

    public function delete(User $user, Cv $cv): void
    {
        $this->ensureOwnedBy($cv, $user, 'CV not found.');
        $cv->delete();
    }

    public function duplicate(User $user, Cv $cv): Cv
    {
        $this->ensureOwnedBy($cv, $user, 'CV not found.');

        $newTitle = $cv->title.' Copy';
        $copy = $cv->replicate();
        $copy->title = $newTitle;
        $copy->slug = $this->uniqueSlug($newTitle);
        $copy->is_default = false;
        $copy->is_public = false;
        $copy->is_active = true;
        $copy->save();

        return $copy->load('template');
    }

    public function setDefault(User $user, Cv $cv): Cv
    {
        $this->ensureOwnedBy($cv, $user, 'CV not found.');
        $user->cvs()->update(['is_default' => false]);
        $cv->update(['is_default' => true]);

        return $cv->fresh();
    }

    public function togglePublic(User $user, Cv $cv): Cv
    {
        $this->ensureOwnedBy($cv, $user, 'CV not found.');
        $cv->update(['is_public' => ! $cv->is_public]);

        return $cv->fresh();
    }

    public function completion(Cv $cv): int
    {
        $sections = [
            $cv->educations()->exists(),
            $cv->experiences()->exists(),
            $cv->skills()->exists(),
            $cv->projects()->exists(),
            $cv->certifications()->exists(),
            $cv->languages()->exists(),
            $cv->references()->exists(),
        ];

        $completed = collect($sections)->filter()->count();

        return (int) round(($completed / count($sections)) * 100);
    }

    public function storeRules(): array
    {
        return [
            'cv_template_id' => [
                'nullable',
                'integer',
                Rule::exists('cv_templates', 'id')->where('is_active', true),
            ],
            'title' => ['required', 'string', 'max:255'],
            'cv_type' => ['required', Rule::in(self::TYPES)],
            'description' => ['nullable', 'string'],
            'is_default' => ['sometimes', 'boolean'],
            'is_public' => ['sometimes', 'boolean'],
        ];
    }

    public function updateRules(): array
    {
        return [
            'cv_template_id' => [
                'sometimes',
                'nullable',
                'integer',
                Rule::exists('cv_templates', 'id')->where('is_active', true),
            ],
            'title' => ['sometimes', 'required', 'string', 'max:255'],
            'cv_type' => ['sometimes', 'required', Rule::in(self::TYPES)],
            'description' => ['nullable', 'string'],
            'is_default' => ['sometimes', 'boolean'],
            'is_public' => ['sometimes', 'boolean'],
            'is_active' => ['sometimes', 'boolean'],
        ];
    }

    protected function uniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $base = Str::slug($title) ?: 'cv';
        $slug = $base.'-'.Str::lower(Str::random(6));
        $counter = 1;

        while (
            Cv::where('slug', $slug)
                ->when($ignoreId, fn ($q) => $q->whereKeyNot($ignoreId))
                ->exists()
        ) {
            $slug = $base.'-'.$counter;
            $counter++;
        }

        return $slug;
    }
}
