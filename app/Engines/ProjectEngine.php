<?php

namespace App\Engines;

use App\Engines\Concerns\OwnsResource;
use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class ProjectEngine
{
    use OwnsResource;

    public function listFor(User $user): Collection
    {
        return $user->projects()->orderBy('display_order')->latest('start_date')->get();
    }

    public function findFor(User $user, Project $project): Project
    {
        $this->ensureOwnedBy($project, $user, 'Project not found.');

        return $project;
    }

    public function create(User $user, array $data): Project
    {
        $validated = validator($data, $this->storeRules())->validate();
        $this->ensureCvOwnedBy($user, (int) $validated['cv_id']);

        return $user->projects()->create($validated);
    }

    public function update(User $user, Project $project, array $data): Project
    {
        $this->ensureOwnedBy($project, $user, 'Project not found.');
        $validated = validator($data, $this->updateRules())->validate();

        if (isset($validated['cv_id'])) {
            $this->ensureCvOwnedBy($user, (int) $validated['cv_id']);
        }

        $project->update($validated);

        return $project->fresh();
    }

    public function delete(User $user, Project $project): void
    {
        $this->ensureOwnedBy($project, $user, 'Project not found.');
        $project->delete();
    }

    public function storeRules(): array
    {
        return [
            'cv_id' => ['required', 'integer', 'exists:cvs,id'],
            'name' => ['required', 'string', 'max:255'],
            'role' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'technologies' => ['nullable', 'string'],
            'url' => ['nullable', 'url', 'max:255'],
            'github_url' => ['nullable', 'url', 'max:255'],
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'is_current' => ['sometimes', 'boolean'],
            'display_order' => ['sometimes', 'integer', 'min:0'],
        ];
    }

    public function updateRules(): array
    {
        return [
            'cv_id' => ['sometimes', 'integer', 'exists:cvs,id'],
            'name' => ['sometimes', 'required', 'string', 'max:255'],
            'role' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'technologies' => ['nullable', 'string'],
            'url' => ['nullable', 'url', 'max:255'],
            'github_url' => ['nullable', 'url', 'max:255'],
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'is_current' => ['sometimes', 'boolean'],
            'display_order' => ['sometimes', 'integer', 'min:0'],
        ];
    }
}
