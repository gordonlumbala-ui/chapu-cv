<?php

namespace App\Engines;

use App\Engines\Concerns\OwnsResource;
use App\Models\Language;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class LanguageEngine
{
    use OwnsResource;

    public function listFor(User $user): Collection
    {
        return $user->languages()->orderBy('language')->get();
    }

    public function findFor(User $user, Language $language): Language
    {
        $this->ensureOwnedBy($language, $user, 'Language record not found.');

        return $language;
    }

    public function create(User $user, array $data): Language
    {
        $validated = validator($data, $this->storeRules())->validate();
        $this->ensureCvOwnedBy($user, (int) $validated['cv_id']);

        return $user->languages()->create($validated);
    }

    public function update(User $user, Language $language, array $data): Language
    {
        $this->ensureOwnedBy($language, $user, 'Language record not found.');
        $validated = validator($data, $this->updateRules())->validate();

        if (isset($validated['cv_id'])) {
            $this->ensureCvOwnedBy($user, (int) $validated['cv_id']);
        }

        $language->update($validated);

        return $language->fresh();
    }

    public function delete(User $user, Language $language): void
    {
        $this->ensureOwnedBy($language, $user, 'Language record not found.');
        $language->delete();
    }

    public function storeRules(): array
    {
        return [
            'cv_id' => ['required', 'integer', 'exists:cvs,id'],
            'language' => ['required', 'string', 'max:255'],
            'proficiency' => ['required', 'string', 'max:255'],
            'percentage' => ['nullable', 'integer', 'min:0', 'max:100'],
        ];
    }

    public function updateRules(): array
    {
        return [
            'cv_id' => ['sometimes', 'integer', 'exists:cvs,id'],
            'language' => ['sometimes', 'required', 'string', 'max:255'],
            'proficiency' => ['sometimes', 'required', 'string', 'max:255'],
            'percentage' => ['nullable', 'integer', 'min:0', 'max:100'],
        ];
    }
}
