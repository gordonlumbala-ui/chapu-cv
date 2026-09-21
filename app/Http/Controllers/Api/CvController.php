<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CvResource;
use App\Models\Cv;
use App\Models\CvTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class CvController extends Controller
{
    public function index(Request $request)
    {
        $cvs = $request->user()
            ->cvs()
            ->with('template')
            ->latest()
            ->get();

        return CvResource::collection($cvs);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'cv_template_id' => [
                'required',
                'integer',
                Rule::exists('cv_templates', 'id')
                    ->where('is_active', true),
            ],
            'title' => ['required', 'string', 'max:255'],
            'cv_type' => [
                'required',
                Rule::in([
                    'professional',
                    'academic',
                    'technical',
                    'job',
                    'custom',
                ]),
            ],
            'description' => ['nullable', 'string'],
            'is_default' => ['sometimes', 'boolean'],
            'is_public' => ['sometimes', 'boolean'],
        ]);

        $user = $request->user();

        if (! empty($validated['is_default']) && $validated['is_default']) {
            $user->cvs()->update(['is_default' => false]);
        }

        $cv = $user->cvs()->create([
            'cv_template_id' => $validated['cv_template_id'],
            'title' => $validated['title'],
            'slug' => Str::slug($validated['title']) . '-' . Str::lower(Str::random(6)),
            'cv_type' => $validated['cv_type'],
            'description' => $validated['description'] ?? null,
            'is_default' => $validated['is_default'] ?? false,
            'is_public' => $validated['is_public'] ?? false,
            'is_active' => true,
        ]);

        $cv->load('template');

        return (new CvResource($cv))
            ->additional([
                'success' => true,
                'message' => 'CV created successfully.',
            ])
            ->response()
            ->setStatusCode(201);
    }

    public function show(Request $request, Cv $cv)
    {
        if ($cv->user_id !== $request->user()->id) {
            return response()->json([
                'success' => false,
                'message' => 'CV not found.',
            ], 404);
        }

        $cv->load('template');

        return new CvResource($cv);
    }

    public function update(Request $request, Cv $cv)
    {
        if ($cv->user_id !== $request->user()->id) {
            return response()->json([
                'success' => false,
                'message' => 'CV not found.',
            ], 404);
        }

        $validated = $request->validate([
            'cv_template_id' => [
                'sometimes',
                'integer',
                Rule::exists('cv_templates', 'id')
                    ->where('is_active', true),
            ],
            'title' => ['sometimes', 'required', 'string', 'max:255'],
            'cv_type' => [
                'sometimes',
                'required',
                Rule::in([
                    'professional',
                    'academic',
                    'technical',
                    'job',
                    'custom',
                ]),
            ],
            'description' => ['nullable', 'string'],
            'is_default' => ['sometimes', 'boolean'],
            'is_public' => ['sometimes', 'boolean'],
            'is_active' => ['sometimes', 'boolean'],
        ]);

        if (($validated['is_default'] ?? false) === true) {
            $request->user()
                ->cvs()
                ->whereKeyNot($cv->id)
                ->update(['is_default' => false]);
        }

        if (isset($validated['title']) && $validated['title'] !== $cv->title) {
            $validated['slug'] = Str::slug($validated['title']) . '-' . Str::lower(Str::random(6));
        }

        $cv->update($validated);
        $cv->load('template');

        return (new CvResource($cv))
            ->additional([
                'success' => true,
                'message' => 'CV updated successfully.',
            ]);
    }

    public function destroy(Request $request, Cv $cv)
    {
        if ($cv->user_id !== $request->user()->id) {
            return response()->json([
                'success' => false,
                'message' => 'CV not found.',
            ], 404);
        }

        $cv->delete();

        return response()->json([
            'success' => true,
            'message' => 'CV deleted successfully.',
        ]);
    }
}