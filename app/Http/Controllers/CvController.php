<?php

namespace App\Http\Controllers;

use App\Models\Cv;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class CvController extends Controller
{
    /**
     * Display the user's CVs.
     */
    public function index(Request $request): View
    {
        $cvs = Cv::where('user_id', $request->user()->id)
            ->with('template')
            ->latest()
            ->get();

        return view('cvs.index', [
            'cvs' => $cvs,
        ]);
    }

    /**
     * Show the create CV form.
     */
    public function create(): View
    {
        return view('cvs.create');
    }

    /**
     * Store a new CV.
     */
    public function store(Request $request): RedirectResponse
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

        /*
         * Generate a unique slug.
         */
        $slug = $this->generateUniqueSlug($validated['title']);

        /*
         * If this CV is marked as default,
         * remove default status from the user's other CVs.
         */
        if ($request->boolean('is_default')) {
            Cv::where('user_id', $user->id)
                ->update(['is_default' => false]);
        }

        $cv = Cv::create([
            'user_id' => $user->id,
            'cv_template_id' => $validated['cv_template_id'] ?? null,
            'title' => $validated['title'],
            'slug' => $slug,
            'cv_type' => $validated['cv_type'],
            'description' => $validated['description'] ?? null,
            'is_default' => $request->boolean('is_default'),
            'is_public' => $request->boolean('is_public'),
            'is_active' => true,
        ]);

        return redirect()
            ->route('cvs.show', $cv)
            ->with('status', 'CV created successfully.');
    }

    /**
     * Display a specific CV.
     */
    public function show(Request $request, Cv $cv): View
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

        return view('cvs.show', [
            'cv' => $cv,
            'completion' => $this->cvCompletion($cv),
        ]);
    }

    /**
     * Show the edit CV form.
     */
    public function edit(Request $request, Cv $cv): View
    {
        $this->authorizeCv($request, $cv);

        return view('cvs.edit', [
            'cv' => $cv,
        ]);
    }

    /**
     * Update a CV.
     */
    public function update(Request $request, Cv $cv): RedirectResponse
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

        $user = $request->user();

        if ($request->boolean('is_default')) {
            Cv::where('user_id', $user->id)
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

        return redirect()
            ->route('cvs.show', $cv)
            ->with('status', 'CV updated successfully.');
    }

    /**
     * Delete a CV.
     */
    public function destroy(Request $request, Cv $cv): RedirectResponse
    {
        $this->authorizeCv($request, $cv);

        $cv->delete();

        return redirect()
            ->route('cvs.index')
            ->with('status', 'CV deleted successfully.');
    }

    /**
     * Duplicate an existing CV.
     */
    public function duplicate(Request $request, Cv $cv): RedirectResponse
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

        return redirect()
            ->route('cvs.show', $newCv)
            ->with('status', 'CV duplicated successfully.');
    }

    /**
     * Set a CV as the user's default CV.
     */
    public function setDefault(Request $request, Cv $cv): RedirectResponse
    {
        $this->authorizeCv($request, $cv);

        Cv::where('user_id', $request->user()->id)
            ->update(['is_default' => false]);

        $cv->update([
            'is_default' => true,
        ]);

        return back()->with('status', 'Default CV updated successfully.');
    }

    /**
     * Toggle public visibility.
     */
    public function togglePublic(Request $request, Cv $cv): RedirectResponse
    {
        $this->authorizeCv($request, $cv);

        $cv->update([
            'is_public' => !$cv->is_public,
        ]);

        return back()->with(
            'status',
            $cv->is_public
                ? 'CV is now public.'
                : 'CV is now private.'
        );
    }

    /**
     * Calculate CV completion percentage.
     */
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

        $completed = collect($sections)
            ->filter()
            ->count();

        return (int) round(
            ($completed / count($sections)) * 100
        );
    }

    /**
     * Ensure the CV belongs to the authenticated user.
     */
    private function authorizeCv(Request $request, Cv $cv): void
    {
        abort_unless(
            $cv->user_id === $request->user()->id,
            403,
            'You are not authorized to access this CV.'
        );
    }

    /**
     * Generate a unique CV slug.
     */
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