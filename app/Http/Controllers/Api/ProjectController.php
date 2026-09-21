<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProjectResource;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index(Request $request)
    {
        $projects = $request->user()
            ->projects()
            ->orderBy('display_order')
            ->latest('start_date')
            ->get();

        return ProjectResource::collection($projects);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'cv_id' => ['required', 'integer', 'exists:cvs,id'],
            'name' => ['required', 'string', 'max:255'],
            'role' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'technologies' => ['nullable', 'string'],
            'url' => ['nullable', 'url', 'max:255'],
            'github_url' => ['nullable', 'url', 'max:255'],
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'is_current' => ['sometimes', 'boolean'],
            'display_order' => ['sometimes', 'integer', 'min:0'],
        ]);

        $request->user()
            ->cvs()
            ->findOrFail($validated['cv_id']);

        $project = $request->user()
            ->projects()
            ->create($validated);

        return (new ProjectResource($project))
            ->additional([
                'success' => true,
                'message' => 'Project added successfully.',
            ])
            ->response()
            ->setStatusCode(201);
    }

    public function show(Request $request, Project $project)
    {
        if ($project->user_id !== $request->user()->id) {
            return response()->json([
                'success' => false,
                'message' => 'Project not found.',
            ], 404);
        }

        return new ProjectResource($project);
    }

    public function update(Request $request, Project $project)
    {
        if ($project->user_id !== $request->user()->id) {
            return response()->json([
                'success' => false,
                'message' => 'Project not found.',
            ], 404);
        }

        $validated = $request->validate([
            'cv_id' => ['sometimes', 'integer', 'exists:cvs,id'],
            'name' => ['sometimes', 'required', 'string', 'max:255'],
            'role' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'technologies' => ['nullable', 'string'],
            'url' => ['nullable', 'url', 'max:255'],
            'github_url' => ['nullable', 'url', 'max:255'],
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'is_current' => ['sometimes', 'boolean'],
            'display_order' => ['sometimes', 'integer', 'min:0'],
        ]);

        if (isset($validated['cv_id'])) {
            $request->user()
                ->cvs()
                ->findOrFail($validated['cv_id']);
        }

        $project->update($validated);

        return (new ProjectResource($project))
            ->additional([
                'success' => true,
                'message' => 'Project updated successfully.',
            ]);
    }

    public function destroy(Request $request, Project $project)
    {
        if ($project->user_id !== $request->user()->id) {
            return response()->json([
                'success' => false,
                'message' => 'Project not found.',
            ], 404);
        }

        $project->delete();

        return response()->json([
            'success' => true,
            'message' => 'Project deleted successfully.',
        ]);
    }
}