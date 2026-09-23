<?php

namespace App\Engines;

use App\Engines\Concerns\OwnsResource;
use App\Models\Certification;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class CertificationEngine
{
    use OwnsResource;

    public function listFor(User $user): Collection
    {
        return $user->certifications()->latest('issue_date')->get();
    }

    public function findFor(User $user, Certification $certification): Certification
    {
        $this->ensureOwnedBy($certification, $user, 'Certification not found.');

        return $certification;
    }

    public function create(User $user, array $data): Certification
    {
        $validated = validator($data, $this->storeRules())->validate();
        $this->ensureCvOwnedBy($user, (int) $validated['cv_id']);

        return $user->certifications()->create($validated);
    }

    public function update(User $user, Certification $certification, array $data): Certification
    {
        $this->ensureOwnedBy($certification, $user, 'Certification not found.');
        $validated = validator($data, $this->updateRules())->validate();

        if (isset($validated['cv_id'])) {
            $this->ensureCvOwnedBy($user, (int) $validated['cv_id']);
        }

        $certification->update($validated);

        return $certification->fresh();
    }

    public function delete(User $user, Certification $certification): void
    {
        $this->ensureOwnedBy($certification, $user, 'Certification not found.');
        $certification->delete();
    }

    public function storeRules(): array
    {
        return [
            'cv_id' => ['required', 'integer', 'exists:cvs,id'],
            'name' => ['required', 'string', 'max:255'],
            'issuing_organization' => ['required', 'string', 'max:255'],
            'credential_id' => ['nullable', 'string', 'max:255'],
            'credential_url' => ['nullable', 'url', 'max:255'],
            'issue_date' => ['required', 'date'],
            'expiry_date' => ['nullable', 'date', 'after_or_equal:issue_date'],
            'does_not_expire' => ['sometimes', 'boolean'],
            'description' => ['nullable', 'string'],
        ];
    }

    public function updateRules(): array
    {
        return [
            'cv_id' => ['sometimes', 'integer', 'exists:cvs,id'],
            'name' => ['sometimes', 'required', 'string', 'max:255'],
            'issuing_organization' => ['sometimes', 'required', 'string', 'max:255'],
            'credential_id' => ['nullable', 'string', 'max:255'],
            'credential_url' => ['nullable', 'url', 'max:255'],
            'issue_date' => ['sometimes', 'required', 'date'],
            'expiry_date' => ['nullable', 'date', 'after_or_equal:issue_date'],
            'does_not_expire' => ['sometimes', 'boolean'],
            'description' => ['nullable', 'string'],
        ];
    }
}
