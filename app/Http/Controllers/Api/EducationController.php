<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\EducationResource;
use App\Models\Education;
use Illuminate\Http\Request;

class EducationController extends Controller
{
    public function index(Request $request)
    {
        $education = $request->user()
            ->educations()
            ->latest('start_date')
            ->get();

        return EducationResource::collection($education);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
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
        ]);

        $cv = $request->user()
            ->cvs()
            ->findOrFail($validated['cv_id']);

        $education = $request->user()
            ->educations()
            ->create($validated);

        return (new EducationResource($education))
            ->additional([
                'success' => true,
                'message' => 'Education added successfully.',
            ])
            ->response()
            ->setStatusCode(201);
    }

    public function show(Request $request, Education $education)
    {
        if ($education->user_id !== $request->user()->id) {
            return response()->json([
                'success' => false,
                'message' => 'Education record not found.',
            ], 404);
        }

        return new EducationResource($education);
    }

    public function update(Request $request, Education $education)
    {
        if ($education->user_id !== $request->user()->id) {
            return response()->json([
                'success' => false,
                'message' => 'Education record not found.',
            ], 404);
        }

        $validated = $request->validate([
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
        ]);

        if (isset($validated['cv_id'])) {
            $request->user()
                ->cvs()
                ->findOrFail($validated['cv_id']);
        }

        $education->update($validated);

        return (new EducationResource($education))
            ->additional([
                'success' => true,
                'message' => 'Education updated successfully.',
            ]);
    }

    public function destroy(Request $request, Education $education)
    {
        if ($education->user_id !== $request->user()->id) {
            return response()->json([
                'success' => false,
                'message' => 'Education record not found.',
            ], 404);
        }

        $education->delete();

        return response()->json([
            'success' => true,
            'message' => 'Education deleted successfully.',
        ]);
    }
}