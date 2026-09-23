<?php

namespace App\Engines;

use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

/**
 * Syncs the mobile flat CV form into profile + CV + section records.
 */
class MobileCvSyncEngine
{
    public function __construct(
        protected CvEngine $cvEngine,
        protected CvTemplateEngine $templateEngine,
        protected ProfileEngine $profileEngine,
    ) {}

    public function sync(User $user, array $data): array
    {
        $validated = validator($data, [
            'full_name' => ['required', 'string', 'max:255'],
            'job_title' => ['nullable', 'string', 'max:150'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:30'],
            'location' => ['nullable', 'string', 'max:255'],
            'summary' => ['nullable', 'string', 'max:2000'],
            'experience' => ['nullable', 'string'],
            'education' => ['nullable', 'string'],
            'skills' => ['nullable', 'string'],
        ])->validate();

        return DB::transaction(function () use ($user, $validated) {
            $profile = $this->profileEngine->update($user, [
                'name' => $validated['full_name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'] ?? null,
                'professional_title' => $validated['job_title'] ?? null,
                'summary' => $validated['summary'] ?? null,
                'city' => $validated['location'] ?? null,
            ]);

            $cv = $this->resolveDefaultCv($user, $validated);

            $this->syncExperience($user, $cv, $validated['experience'] ?? '');
            $this->syncEducation($user, $cv, $validated['education'] ?? '');
            $this->syncSkills($user, $cv, $validated['skills'] ?? '');

            $cv = $this->cvEngine->findWithSections($user, $cv->fresh());

            return [
                'user' => $profile,
                'cv' => $cv,
                'completion' => $this->profileEngine->completion($profile),
                'cv_completion' => $this->cvEngine->completion($cv),
            ];
        });
    }

    public function loadForMobile(User $user): array
    {
        $cv = $user->cvs()
            ->with(['educations', 'experiences', 'skills'])
            ->where('is_default', true)
            ->first()
            ?? $user->cvs()->with(['educations', 'experiences', 'skills'])->latest()->first();

        $experienceText = $cv?->experiences
            ?->map(fn ($item) => trim(collect([
                $item->company,
                $item->job_title,
                $item->description,
            ])->filter()->implode(' — ')))
            ->filter()
            ->implode("\n") ?? '';

        $educationText = $cv?->educations
            ?->map(fn ($item) => trim(collect([
                $item->institution,
                $item->program,
                $item->description,
            ])->filter()->implode(' — ')))
            ->filter()
            ->implode("\n") ?? '';

        $skillsText = $cv?->skills?->pluck('name')->filter()->implode(', ')
            ?? $user->skills()->pluck('name')->filter()->implode(', ');

        return [
            'full_name' => $user->name ?? '',
            'job_title' => $user->professional_title ?? '',
            'email' => $user->email ?? '',
            'phone' => $user->phone ?? '',
            'location' => $user->city ?? '',
            'summary' => $user->summary ?? '',
            'experience' => $experienceText,
            'education' => $educationText,
            'skills' => $skillsText,
            'cv_id' => $cv?->id,
        ];
    }

    protected function resolveDefaultCv(User $user, array $validated): \App\Models\Cv
    {
        $cv = $user->cvs()->where('is_default', true)->first()
            ?? $user->cvs()->latest()->first();

        $title = filled($validated['job_title'] ?? null)
            ? $validated['job_title'].' CV'
            : ($validated['full_name'].' CV');

        if ($cv) {
            return $this->cvEngine->update($user, $cv, [
                'title' => $title,
                'cv_type' => $cv->cv_type ?: 'professional',
                'description' => $validated['summary'] ?? $cv->description,
                'is_default' => true,
            ]);
        }

        $templateId = $this->templateEngine->firstActiveId();

        return $this->cvEngine->create($user, [
            'cv_template_id' => $templateId,
            'title' => $title,
            'cv_type' => 'professional',
            'description' => $validated['summary'] ?? null,
            'is_default' => true,
            'is_public' => false,
        ]);
    }

    protected function syncExperience(User $user, $cv, string $text): void
    {
        $user->experiences()->where('cv_id', $cv->id)->delete();

        if (! filled(trim($text))) {
            return;
        }

        $user->experiences()->create([
            'cv_id' => $cv->id,
            'job_title' => $user->professional_title ?: 'Professional Experience',
            'company' => 'Career History',
            'location' => $user->city,
            'start_date' => Carbon::now()->subYears(1)->toDateString(),
            'is_current' => true,
            'description' => trim($text),
        ]);
    }

    protected function syncEducation(User $user, $cv, string $text): void
    {
        $user->educations()->where('cv_id', $cv->id)->delete();

        if (! filled(trim($text))) {
            return;
        }

        $user->educations()->create([
            'cv_id' => $cv->id,
            'education_level' => 'Other',
            'institution' => 'Education',
            'program' => 'Studies',
            'start_date' => Carbon::now()->subYears(4)->toDateString(),
            'description' => trim($text),
        ]);
    }

    protected function syncSkills(User $user, $cv, string $text): void
    {
        $names = collect(preg_split('/[,;\n]+/', $text) ?: [])
            ->map(fn ($name) => trim($name))
            ->filter()
            ->unique()
            ->values();

        $user->skills()->delete();

        $skillIds = [];
        foreach ($names as $name) {
            $skill = $user->skills()->create([
                'name' => $name,
                'category' => 'General',
                'level' => 'intermediate',
            ]);
            $skillIds[] = $skill->id;
        }

        $cv->skills()->sync($skillIds);
    }
}
