<?php

namespace App\Http\Controllers;

use App\Engines\ProjectEngine;
use App\Models\Project;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProjectController extends Controller
{
    public function __construct(protected ProjectEngine $engine) {}

    public function index(Request $request): View
    {
        return view('projects.index', [
            'projects' => $this->engine->listFor($request->user()),
        ]);
    }

    public function create(): View
    {
        return view('projects.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $this->engine->create($request->user(), $request->all());

        return redirect()
            ->route('projects.index')
            ->with('status', 'Project added successfully.');
    }

    public function show(Request $request, Project $project): View
    {
        return view('projects.show', [
            'project' => $this->engine->findFor($request->user(), $project),
        ]);
    }

    public function edit(Request $request, Project $project): View
    {
        return view('projects.edit', [
            'project' => $this->engine->findFor($request->user(), $project),
        ]);
    }

    public function update(Request $request, Project $project): RedirectResponse
    {
        $this->engine->update($request->user(), $project, $request->all());

        return redirect()
            ->route('projects.index')
            ->with('status', 'Project updated successfully.');
    }

    public function destroy(Request $request, Project $project): RedirectResponse
    {
        $this->engine->delete($request->user(), $project);

        return redirect()
            ->route('projects.index')
            ->with('status', 'Project deleted successfully.');
    }
}
