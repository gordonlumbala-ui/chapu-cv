<?php

namespace App\Http\Controllers;

use App\Engines\SkillEngine;
use App\Models\Skill;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SkillController extends Controller
{
    public function __construct(protected SkillEngine $engine) {}

    public function index(Request $request): View
    {
        return view('skills.index', [
            'skills' => $this->engine->listFor($request->user()),
        ]);
    }

    public function create(): View
    {
        return view('skills.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $this->engine->create($request->user(), $request->all());

        return redirect()
            ->route('skills.index')
            ->with('status', 'Skill added successfully.');
    }

    public function show(Request $request, Skill $skill): View
    {
        return view('skills.show', [
            'skill' => $this->engine->findFor($request->user(), $skill),
        ]);
    }

    public function edit(Request $request, Skill $skill): View
    {
        return view('skills.edit', [
            'skill' => $this->engine->findFor($request->user(), $skill),
        ]);
    }

    public function update(Request $request, Skill $skill): RedirectResponse
    {
        $this->engine->update($request->user(), $skill, $request->all());

        return redirect()
            ->route('skills.index')
            ->with('status', 'Skill updated successfully.');
    }

    public function destroy(Request $request, Skill $skill): RedirectResponse
    {
        $this->engine->delete($request->user(), $skill);

        return redirect()
            ->route('skills.index')
            ->with('status', 'Skill deleted successfully.');
    }
}
