<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    /**
     * Get the authenticated user's profile.
     */
    public function show(Request $request): JsonResponse
    {
        $user = $request->user();

        return response()->json([
            'success' => true,
            'message' => 'Profile retrieved successfully.',
            'data' => [
                'user' => $user,
                'completion' => $this->profileCompletion($user),
            ],
        ]);
    }

    /**
     * Update the authenticated user's profile.
     */
    public function update(Request $request): JsonResponse
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
            'date_of_birth.before' => 'Date of birth must be a date in the past.',
        ]);

        $user->forceFill($validated)->save();

        return response()->json([
            'success' => true,
            'message' => 'Profile updated successfully.',
            'data' => [
                'user' => $user->fresh(),
                'completion' => $this->profileCompletion($user),
            ],
        ]);
    }

    /**
     * Deactivate the authenticated user's account.
     */
    public function deactivate(Request $request): JsonResponse
    {
        $user = $request->user();

        $user->forceFill([
            'is_active' => false,
        ])->save();

        Auth::logout();

        return response()->json([
            'success' => true,
            'message' => 'Your account has been deactivated successfully.',
        ]);
    }

    /**
     * Calculate profile completeness.
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
}