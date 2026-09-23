<?php

namespace App\Engines;

use App\Models\User;
use Illuminate\Validation\Rule;

class ProfileEngine
{
    public function completion(User $user): int
    {
        $fields = [
            $user->name,
            $user->email,
            $user->phone,
            $user->professional_title,
            $user->summary,
            $user->address,
            $user->city,
            $user->country,
            $user->date_of_birth,
            $user->profile_photo_path,
        ];

        $filled = collect($fields)->filter(fn ($value) => filled($value))->count();

        return (int) round(($filled / count($fields)) * 100);
    }

    public function cvCompletion(User $user): int
    {
        $cv = $user->cvs()
            ->withCount([
                'educations',
                'experiences',
                'skills',
                'projects',
                'certifications',
                'languages',
                'references',
            ])
            ->latest()
            ->first();

        if (! $cv) {
            return 0;
        }

        $sections = [
            $cv->educations_count > 0,
            $cv->experiences_count > 0,
            $cv->skills_count > 0,
            $cv->projects_count > 0,
            $cv->certifications_count > 0,
            $cv->languages_count > 0,
            $cv->references_count > 0,
        ];

        $completed = collect($sections)->filter()->count();

        return (int) round(($completed / count($sections)) * 100);
    }

    public function update(User $user, array $data): User
    {
        $validated = validator($data, $this->updateRules($user))->validate();
        $user->forceFill($validated)->save();

        return $user->fresh();
    }

    public function deactivate(User $user): void
    {
        $user->forceFill(['is_active' => false])->save();
    }

    public function updateRules(User $user): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->id),
            ],
            'phone' => ['nullable', 'string', 'max:30'],
            'professional_title' => ['nullable', 'string', 'max:150'],
            'summary' => ['nullable', 'string', 'max:2000'],
            'address' => ['nullable', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:100'],
            'country' => ['nullable', 'string', 'max:100'],
            'date_of_birth' => ['nullable', 'date', 'before:today'],
            'gender' => [
                'nullable',
                Rule::in(['male', 'female', 'other', 'prefer_not_to_say']),
            ],
            'website' => ['nullable', 'url', 'max:255'],
            'linkedin_url' => ['nullable', 'url', 'max:255'],
            'github_url' => ['nullable', 'url', 'max:255'],
        ];
    }
}
