<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ExperienceResource;
use App\Models\Experience;
use Illuminate\Http\Request;

class ExperienceController extends Controller
{
    public function index(Request $request)
    {
        $experiences = $request->user()
            ->experiences()
            ->latest('start_date')
            ->get();

        return ExperienceResource::collection($experiences);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'cv_id' => ['required', 'integer', 'exists:cvs,id'],
            'job_title' => ['required', 'string', 'max:255'],
            'company' => ['required', 'string', 'max:255'],
            'location' => ['nullable', 'string', 'max:255'],
            'start_date' => ['required', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'is_current' => ['sometimes', 'boolean'],
            'description' => ['nullable', 'string'],
            'achievements' => ['nullable', 'string'],
        ]);

        $request->user()
            ->cvs()
            ->findOrFail($validated['cv_id']);

        $experience = $request->user()
            ->experiences()
            ->create($validated);

        return (new ExperienceResource($experience))
            ->additional([
                'success' => true,
                'message' => 'Experience added successfully.',
            ])
            ->response()
            ->setStatusCode(201);
    }

    public function show(Request $request, Experience $experience)
    {
        if ($experience->user_id !== $request->user()->id) {
            return response()->json([
                'success' => false,
                'message' => 'Experience record not found.',
            ], 404);
        }

        return new ExperienceResource($experience);
    }

    public function update(Request $request, Experience $experience)
    {
        if ($experience->user_id !== $request->user()->id) {
            return response()->json([
                'success' => false,
                'message' => 'Experience record not found.',
            ], 404);
        }

        $validated = $request->validate([
            'cv_id' => ['sometimes', 'integer', 'exists:cvs,id'],
            'job_title' => ['sometimes', 'required', 'string', 'max:255'],
            'company' => ['sometimes', 'required', 'string', 'max:255'],
            'location' => ['nullable', 'string', 'max:255'],
            'start_date' => ['sometimes', 'required', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'is_current' => ['sometimes', 'boolean'],
            'description' => ['nullable', 'string'],
            'achievements' => ['nullable', 'string'],
        ]);

        if (isset($validated['cv_id'])) {
            $request->user()
                ->cvs()
                ->findOrFail($validated['cv_id']);
        }

        $experience->update($validated);

        return (new ExperienceResource($experience))
            ->additional([
                'success' => true,
                'message' => 'Experience updated successfully.',
            ]);
    }

    public function destroy(Request $request, Experience $experience)
    {
        if ($experience->user_id !== $request->user()->id) {
            return response()->json([
                'success' => false,
                'message' => 'Experience record not found.',
            ], 404);
        }

        $experience->delete();

        return response()->json([
            'success' => true,
            'message' => 'Experience deleted successfully.',
        ]);
    }
}