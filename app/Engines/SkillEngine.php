<?php

namespace App\Engines;

use App\Engines\Concerns\OwnsResource;
use App\Models\Skill;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class SkillEngine
{
    use OwnsResource;

    public function listFor(User $user): Collection
    {
        return $user->skills()->orderBy('category')->orderBy('name')->get();
    }

    public function findFor(User $user, Skill $skill): Skill
    {
        $this->ensureOwnedBy($skill, $user, 'Skill not found.');

        return $skill;
    }

    public function create(User $user, array $data): Skill
    {
        $validated = validator($data, $this->storeRules())->validate();

        return $user->skills()->create($validated);
    }

    public function update(User $user, Skill $skill, array $data): Skill
    {
        $this->ensureOwnedBy($skill, $user, 'Skill not found.');
        $validated = validator($data, $this->updateRules())->validate();
        $skill->update($validated);

        return $skill->fresh();
    }

    public function delete(User $user, Skill $skill): void
    {
        $this->ensureOwnedBy($skill, $user, 'Skill not found.');
        $skill->delete();
    }

    public function storeRules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'category' => ['nullable', 'string', 'max:255'],
            'level' => ['nullable', 'string', 'max:255'],
            'percentage' => ['nullable', 'integer', 'min:0', 'max:100'],
        ];
    }

    public function updateRules(): array
    {
        return [
            'name' => ['sometimes', 'required', 'string', 'max:255'],
            'category' => ['nullable', 'string', 'max:255'],
            'level' => ['nullable', 'string', 'max:255'],
            'percentage' => ['nullable', 'integer', 'min:0', 'max:100'],
        ];
    }
}
