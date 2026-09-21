<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\LanguageResource;
use App\Models\Language;
use Illuminate\Http\Request;

class LanguageController extends Controller
{
    public function index(Request $request)
    {
        $languages = $request->user()
            ->languages()
            ->orderBy('language')
            ->get();

        return LanguageResource::collection($languages);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'cv_id' => ['required', 'integer', 'exists:cvs,id'],
            'language' => ['required', 'string', 'max:255'],
            'proficiency' => ['required', 'string', 'max:255'],
            'percentage' => ['nullable', 'integer', 'min:0', 'max:100'],
        ]);

        $request->user()
            ->cvs()
            ->findOrFail($validated['cv_id']);

        $language = $request->user()
            ->languages()
            ->create($validated);

        return (new LanguageResource($language))
            ->additional([
                'success' => true,
                'message' => 'Language added successfully.',
            ])
            ->response()
            ->setStatusCode(201);
    }

    public function show(Request $request, Language $language)
    {
        if ($language->user_id !== $request->user()->id) {
            return response()->json([
                'success' => false,
                'message' => 'Language record not found.',
            ], 404);
        }

        return new LanguageResource($language);
    }

    public function update(Request $request, Language $language)
    {
        if ($language->user_id !== $request->user()->id) {
            return response()->json([
                'success' => false,
                'message' => 'Language record not found.',
            ], 404);
        }

        $validated = $request->validate([
            'cv_id' => ['sometimes', 'integer', 'exists:cvs,id'],
            'language' => ['sometimes', 'required', 'string', 'max:255'],
            'proficiency' => ['sometimes', 'required', 'string', 'max:255'],
            'percentage' => ['nullable', 'integer', 'min:0', 'max:100'],
        ]);

        if (isset($validated['cv_id'])) {
            $request->user()
                ->cvs()
                ->findOrFail($validated['cv_id']);
        }

        $language->update($validated);

        return (new LanguageResource($language))
            ->additional([
                'success' => true,
                'message' => 'Language updated successfully.',
            ]);
    }

    public function destroy(Request $request, Language $language)
    {
        if ($language->user_id !== $request->user()->id) {
            return response()->json([
                'success' => false,
                'message' => 'Language record not found.',
            ], 404);
        }

        $language->delete();

        return response()->json([
            'success' => true,
            'message' => 'Language deleted successfully.',
        ]);
    }
}