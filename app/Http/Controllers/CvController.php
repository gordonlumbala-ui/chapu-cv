<?php

namespace App\Http\Controllers;

use App\Engines\CvEngine;
use App\Models\Cv;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CvController extends Controller
{
    public function __construct(protected CvEngine $engine) {}

    public function index(Request $request): View
    {
        return view('cvs.index', [
            'cvs' => $this->engine->listFor($request->user()),
        ]);
    }

    public function create(): View
    {
        return view('cvs.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $cv = $this->engine->create($request->user(), $request->all());

        return redirect()
            ->route('cvs.show', $cv)
            ->with('status', 'CV created successfully.');
    }

    public function show(Request $request, Cv $cv): View
    {
        $cv = $this->engine->findWithSections($request->user(), $cv);

        return view('cvs.show', [
            'cv' => $cv,
            'completion' => $this->engine->completion($cv),
        ]);
    }

    public function edit(Request $request, Cv $cv): View
    {
        return view('cvs.edit', [
            'cv' => $this->engine->findFor($request->user(), $cv),
        ]);
    }

    public function update(Request $request, Cv $cv): RedirectResponse
    {
        $cv = $this->engine->update($request->user(), $cv, $request->all());

        return redirect()
            ->route('cvs.show', $cv)
            ->with('status', 'CV updated successfully.');
    }

    public function destroy(Request $request, Cv $cv): RedirectResponse
    {
        $this->engine->delete($request->user(), $cv);

        return redirect()
            ->route('cvs.index')
            ->with('status', 'CV deleted successfully.');
    }

    public function duplicate(Request $request, Cv $cv): RedirectResponse
    {
        $newCv = $this->engine->duplicate($request->user(), $cv);

        return redirect()
            ->route('cvs.show', $newCv)
            ->with('status', 'CV duplicated successfully.');
    }

    public function setDefault(Request $request, Cv $cv): RedirectResponse
    {
        $this->engine->setDefault($request->user(), $cv);

        return back()->with('status', 'Default CV updated successfully.');
    }

    public function togglePublic(Request $request, Cv $cv): RedirectResponse
    {
        $cv = $this->engine->togglePublic($request->user(), $cv);

        return back()->with(
            'status',
            $cv->is_public ? 'CV is now public.' : 'CV is now private.'
        );
    }
}
