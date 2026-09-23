<?php

namespace App\Http\Controllers;

use App\Engines\EducationEngine;
use App\Models\Education;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EducationController extends Controller
{
    public function __construct(protected EducationEngine $engine) {}

    public function index(Request $request): View
    {
        return view('educations.index', [
            'educations' => $this->engine->listFor($request->user()),
        ]);
    }

    public function create(): View
    {
        return view('educations.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $this->engine->create($request->user(), $request->all());

        return redirect()
            ->route('educations.index')
            ->with('status', 'Education added successfully.');
    }

    public function show(Request $request, Education $education): View
    {
        return view('educations.show', [
            'education' => $this->engine->findFor($request->user(), $education),
        ]);
    }

    public function edit(Request $request, Education $education): View
    {
        return view('educations.edit', [
            'education' => $this->engine->findFor($request->user(), $education),
        ]);
    }

    public function update(Request $request, Education $education): RedirectResponse
    {
        $this->engine->update($request->user(), $education, $request->all());

        return redirect()
            ->route('educations.index')
            ->with('status', 'Education updated successfully.');
    }

    public function destroy(Request $request, Education $education): RedirectResponse
    {
        $this->engine->delete($request->user(), $education);

        return redirect()
            ->route('educations.index')
            ->with('status', 'Education deleted successfully.');
    }
}
