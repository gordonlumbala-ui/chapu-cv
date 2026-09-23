<?php

namespace App\Engines;

use App\Engines\Concerns\OwnsResource;
use App\Models\Education;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class EducationEngine
{
    use OwnsResource;

    public function listFor(User $user): Collection
    {
        return $user->educations()->latest('start_date')->get();
    }

    public function findFor(User $user, Education $education): Education
    {
        $this->ensureOwnedBy($education, $user, 'Education record not found.');

        return $education;
    }

    public function create(User $user, array $data): Education
    {
        $validated = validator($data, $this->storeRules())->validate();
        $this->ensureCvOwnedBy($user, (int) $validated['cv_id']);

        return $user->educations()->create($validated);
    }

    public function update(User $user, Education $education, array $data): Education
    {
        $this->ensureOwnedBy($education, $user, 'Education record not found.');
        $validated = validator($data, $this->updateRules())->validate();

        if (isset($validated['cv_id'])) {
            $this->ensureCvOwnedBy($user, (int) $validated['cv_id']);
        }

        $education->update($validated);

        return $education->fresh();
    }

    public function delete(User $user, Education $education): void
    {
        $this->ensureOwnedBy($education, $user, 'Education record not found.');
        $education->delete();
    }

    public function storeRules(): array
    {
        return [
            'cv_id' => ['required', 'integer', 'exists:cvs,id'],
            'education_level' => ['required', 'string', 'max:255'],
            'institution' => ['required', 'string', 'max:255'],
            'program' => ['required', 'string', 'max:255'],
            'field_of_study' => ['nullable', 'string', 'max:255'],
            'start_date' => ['required', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'grade' => ['nullable', 'string', 'max:255'],
            'certificate' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ];
    }

    public function updateRules(): array
    {
        return [
            'cv_id' => ['sometimes', 'integer', 'exists:cvs,id'],
            'education_level' => ['sometimes', 'required', 'string', 'max:255'],
            'institution' => ['sometimes', 'required', 'string', 'max:255'],
            'program' => ['sometimes', 'required', 'string', 'max:255'],
            'field_of_study' => ['nullable', 'string', 'max:255'],
            'start_date' => ['sometimes', 'required', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'grade' => ['nullable', 'string', 'max:255'],
            'certificate' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
        ];
    }
}
