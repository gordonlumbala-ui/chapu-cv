<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cv;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CvController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $cvs = Cv::where('user_id', $request->user()->id)
            ->with('template')
            ->latest()
            ->get();

        return response()->json([
            'success' => true,
            'data' => $cvs,
        ]);
    }

    public function show(Request $request, Cv $cv): JsonResponse
    {
        $this->authorizeCv($request, $cv);

        $cv->load([
            'template',
            'educations',
            'experiences',
            'skills',
            'projects',
            'certifications',
            'languages',
            'references',
        ]);

        return response()->json([
            'success' => true,
            'data' => [
                'cv' => $cv,
                'completion' => $this->cvCompletion($cv),
            ],
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'cv_type' => [
                'required',
                'string',
                'in:professional,student,graduate,academic,technical,creative,internship,international',
            ],
            'description' => ['nullable', 'string', 'max:2000'],
            'cv_template_id' => ['nullable', 'exists:cv_templates,id'],
            'is_default' => ['nullable', 'boolean'],
            'is_public' => ['nullable', 'boolean'],
        ]);

        $user = $request->user();

        if ($request->boolean('is_default')) {
            Cv::where('user_id', $user->id)
                ->update(['is_default' => false]);
        }

        $cv = Cv::create([
            'user_id' => $user->id,
            'cv_template_id' => $validated['cv_template_id'] ?? null,
            'title' => $validated['title'],
            'slug' => $this->generateUniqueSlug($validated['title']),
            'cv_type' => $validated['cv_type'],
            'description' => $validated['description'] ?? null,
            'is_default' => $request->boolean('is_default'),
            'is_public' => $request->boolean('is_public'),
            'is_active' => true,
        ]);

        $cv->load('template');

        return response()->json([
            'success' => true,
            'message' => 'CV created successfully.',
            'data' => $cv,
        ], 201);
    }

    public function update(Request $request, Cv $cv): JsonResponse
    {
        $this->authorizeCv($request, $cv);

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'cv_type' => [
                'required',
                'string',
                'in:professional,student,graduate,academic,technical,creative,internship,international',
            ],
            'description' => ['nullable', 'string', 'max:2000'],
            'cv_template_id' => ['nullable', 'exists:cv_templates,id'],
            'is_default' => ['nullable', 'boolean'],
            'is_public' => ['nullable', 'boolean'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        if ($request->boolean('is_default')) {
            Cv::where('user_id', $request->user()->id)
                ->where('id', '!=', $cv->id)
                ->update(['is_default' => false]);
        }

        $cv->update([
            'cv_template_id' => $validated['cv_template_id'] ?? null,
            'title' => $validated['title'],
            'cv_type' => $validated['cv_type'],
            'description' => $validated['description'] ?? null,
            'is_default' => $request->boolean('is_default'),
            'is_public' => $request->boolean('is_public'),
            'is_active' => $request->has('is_active')
                ? $request->boolean('is_active')
                : $cv->is_active,
        ]);

        $cv->load('template');

        return response()->json([
            'success' => true,
            'message' => 'CV updated successfully.',
            'data' => $cv,
        ]);
    }

    public function destroy(Request $request, Cv $cv): JsonResponse
    {
        $this->authorizeCv($request, $cv);

        $cv->delete();

        return response()->json([
            'success' => true,
            'message' => 'CV deleted successfully.',
        ]);
    }

    public function duplicate(Request $request, Cv $cv): JsonResponse
    {
        $this->authorizeCv($request, $cv);

        $newTitle = $cv->title . ' Copy';

        $newCv = $cv->replicate();
        $newCv->title = $newTitle;
        $newCv->slug = $this->generateUniqueSlug($newTitle);
        $newCv->is_default = false;
        $newCv->is_public = false;
        $newCv->is_active = true;
        $newCv->save();

        $newCv->load('template');

        return response()->json([
            'success' => true,
            'message' => 'CV duplicated successfully.',
            'data' => $newCv,
        ], 201);
    }

    public function setDefault(Request $request, Cv $cv): JsonResponse
    {
        $this->authorizeCv($request, $cv);

        Cv::where('user_id', $request->user()->id)
            ->update(['is_default' => false]);

        $cv->update([
            'is_default' => true,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Default CV updated successfully.',
            'data' => $cv,
        ]);
    }

    public function togglePublic(Request $request, Cv $cv): JsonResponse
    {
        $this->authorizeCv($request, $cv);

        $cv->update([
            'is_public' => !$cv->is_public,
        ]);

        return response()->json([
            'success' => true,
            'message' => $cv->is_public
                ? 'CV is now public.'
                : 'CV is now private.',
            'data' => $cv,
        ]);
    }

    private function cvCompletion(Cv $cv): int
    {
        $sections = [
            $cv->educations()->exists(),
            $cv->experiences()->exists(),
            $cv->skills()->exists(),
            $cv->projects()->exists(),
            $cv->certifications()->exists(),
            $cv->languages()->exists(),
            $cv->references()->exists(),
        ];

        $completed = collect($sections)->filter()->count();

        return (int) round(
            ($completed / count($sections)) * 100
        );
    }

    private function authorizeCv(Request $request, Cv $cv): void
    {
        abort_unless(
            $cv->user_id === $request->user()->id,
            403,
            'You are not authorized to access this CV.'
        );
    }

    private function generateUniqueSlug(string $title): string
    {
        $baseSlug = Str::slug($title);
        $slug = $baseSlug;
        $counter = 1;

        while (Cv::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }
}