<?php

namespace App\Http\Controllers;

use App\Engines\ExperienceEngine;
use App\Models\Experience;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ExperienceController extends Controller
{
    public function __construct(protected ExperienceEngine $engine) {}

    public function index(Request $request): View
    {
        return view('experiences.index', [
            'experiences' => $this->engine->listFor($request->user()),
        ]);
    }

    public function create(): View
    {
        return view('experiences.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $this->engine->create($request->user(), $request->all());

        return redirect()
            ->route('experiences.index')
            ->with('status', 'Experience added successfully.');
    }

    public function show(Request $request, Experience $experience): View
    {
        return view('experiences.show', [
            'experience' => $this->engine->findFor($request->user(), $experience),
        ]);
    }

    public function edit(Request $request, Experience $experience): View
    {
        return view('experiences.edit', [
            'experience' => $this->engine->findFor($request->user(), $experience),
        ]);
    }

    public function update(Request $request, Experience $experience): RedirectResponse
    {
        $this->engine->update($request->user(), $experience, $request->all());

        return redirect()
            ->route('experiences.index')
            ->with('status', 'Experience updated successfully.');
    }

    public function destroy(Request $request, Experience $experience): RedirectResponse
    {
        $this->engine->delete($request->user(), $experience);

        return redirect()
            ->route('experiences.index')
            ->with('status', 'Experience deleted successfully.');
    }
}
