<?php

namespace App\Http\Controllers;

use App\Models\Cv;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Show the authenticated user's profile page.
     */
    public function index(Request $request): View
    {
        $user = $request->user();

        return view('profile.show', [
            'user' => $user,
            'completion' => $this->profileCompletion($user),
            'cvCompletion' => $this->cvCompletion($user),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request): RedirectResponse
    {
        $user = $request->user();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->id),
            ],

            'photo' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],

            'phone' => ['nullable', 'string', 'max:30'],
            'professional_title' => ['nullable', 'string', 'max:150'],
            'summary' => ['nullable', 'string', 'max:2000'],

            'address' => ['nullable', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:100'],
            'country' => ['nullable', 'string', 'max:100'],

            'date_of_birth' => [
                'nullable',
                'date',
                'before:today',
            ],

            'gender' => [
                'nullable',
                Rule::in([
                    'male',
                    'female',
                    'other',
                    'prefer_not_to_say',
                ]),
            ],

            'website' => ['nullable', 'url', 'max:255'],
            'linkedin_url' => ['nullable', 'url', 'max:255'],
            'github_url' => ['nullable', 'url', 'max:255'],
        ], [
            'photo.max' => 'Profile photo must not be larger than 2MB.',
            'date_of_birth.before' => 'Date of birth must be a date in the past.',
        ]);

        if ($request->hasFile('photo')) {
            $user->updateProfilePhoto($request->file('photo'));
        }

        unset($validated['photo']);

        $user->forceFill($validated)->save();

        return back()->with('status', 'Profile updated successfully.');
    }

    /**
     * Remove the user's profile photo.
     */
    public function destroyPhoto(Request $request): RedirectResponse
    {
        $request->user()->deleteProfilePhoto();

        return back()->with('status', 'Profile photo removed.');
    }

    /**
     * Deactivate the authenticated user's account.
     *
     * User data remains intact.
     */
    public function deactivate(Request $request): RedirectResponse
    {
        $request->user()
            ->forceFill(['is_active' => false])
            ->save();

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')
            ->with('status', 'Your account has been deactivated.');
    }

    /**
     * Calculate profile completeness.
     *
     * This measures account/profile information only.
     */
    private function profileCompletion($user): int
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

        $filled = collect($fields)
            ->filter(fn ($value) => filled($value))
            ->count();

        return (int) round(
            ($filled / count($fields)) * 100
        );
    }

    /**
     * Calculate CV completeness.
     *
     * This checks whether the user has created CV-related
     * information such as education, experience, skills,
     * projects and other important sections.
     */
    private function cvCompletion($user): int
    {
        /*
         * If the Cv model/table has not been created yet,
         * return 0 instead of causing the profile page to fail.
         */
        if (!class_exists(Cv::class)) {
            return 0;
        }

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

        if (!$cv) {
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

        $completed = collect($sections)
            ->filter()
            ->count();

        return (int) round(
            ($completed / count($sections)) * 100
        );
    }
}