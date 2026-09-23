<?php

namespace App\Http\Controllers\Api;

use App\Engines\ProjectEngine;
use App\Http\Controllers\Controller;
use App\Http\Resources\ProjectResource;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function __construct(protected ProjectEngine $engine) {}

    public function index(Request $request)
    {
        return ProjectResource::collection($this->engine->listFor($request->user()));
    }

    public function store(Request $request)
    {
        $project = $this->engine->create($request->user(), $request->all());

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
        return new ProjectResource($this->engine->findFor($request->user(), $project));
    }

    public function update(Request $request, Project $project)
    {
        $project = $this->engine->update($request->user(), $project, $request->all());

        return (new ProjectResource($project))->additional([
            'success' => true,
            'message' => 'Project updated successfully.',
        ]);
    }

    public function destroy(Request $request, Project $project)
    {
        $this->engine->delete($request->user(), $project);

        return response()->json([
            'success' => true,
            'message' => 'Project deleted successfully.',
        ]);
    }
}
