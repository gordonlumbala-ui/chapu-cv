<?php

namespace App\Engines;

use App\Engines\Concerns\OwnsResource;
use App\Models\Experience;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class ExperienceEngine
{
    use OwnsResource;

    public function listFor(User $user): Collection
    {
        return $user->experiences()->latest('start_date')->get();
    }

    public function findFor(User $user, Experience $experience): Experience
    {
        $this->ensureOwnedBy($experience, $user, 'Experience record not found.');

        return $experience;
    }

    public function create(User $user, array $data): Experience
    {
        $validated = validator($data, $this->storeRules())->validate();
        $this->ensureCvOwnedBy($user, (int) $validated['cv_id']);

        return $user->experiences()->create($validated);
    }

    public function update(User $user, Experience $experience, array $data): Experience
    {
        $this->ensureOwnedBy($experience, $user, 'Experience record not found.');
        $validated = validator($data, $this->updateRules())->validate();

        if (isset($validated['cv_id'])) {
            $this->ensureCvOwnedBy($user, (int) $validated['cv_id']);
        }

        $experience->update($validated);

        return $experience->fresh();
    }

    public function delete(User $user, Experience $experience): void
    {
        $this->ensureOwnedBy($experience, $user, 'Experience record not found.');
        $experience->delete();
    }

    public function storeRules(): array
    {
        return [
            'cv_id' => ['required', 'integer', 'exists:cvs,id'],
            'job_title' => ['required', 'string', 'max:255'],
            'company' => ['required', 'string', 'max:255'],
            'location' => ['nullable', 'string', 'max:255'],
            'start_date' => ['required', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'is_current' => ['sometimes', 'boolean'],
            'description' => ['nullable', 'string'],
            'achievements' => ['nullable', 'string'],
        ];
    }

    public function updateRules(): array
    {
        return [
            'cv_id' => ['sometimes', 'integer', 'exists:cvs,id'],
            'job_title' => ['sometimes', 'required', 'string', 'max:255'],
            'company' => ['sometimes', 'required', 'string', 'max:255'],
            'location' => ['nullable', 'string', 'max:255'],
            'start_date' => ['sometimes', 'required', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'is_current' => ['sometimes', 'boolean'],
            'description' => ['nullable', 'string'],
            'achievements' => ['nullable', 'string'],
        ];
    }
}
