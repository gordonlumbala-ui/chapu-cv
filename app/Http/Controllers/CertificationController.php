<?php

namespace App\Http\Controllers;

use App\Engines\CertificationEngine;
use App\Models\Certification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CertificationController extends Controller
{
    public function __construct(protected CertificationEngine $engine) {}

    public function index(Request $request): View
    {
        return view('certifications.index', [
            'certifications' => $this->engine->listFor($request->user()),
        ]);
    }

    public function create(): View
    {
        return view('certifications.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $this->engine->create($request->user(), $request->all());

        return redirect()
            ->route('certifications.index')
            ->with('status', 'Certification added successfully.');
    }

    public function show(Request $request, Certification $certification): View
    {
        return view('certifications.show', [
            'certification' => $this->engine->findFor($request->user(), $certification),
        ]);
    }

    public function edit(Request $request, Certification $certification): View
    {
        return view('certifications.edit', [
            'certification' => $this->engine->findFor($request->user(), $certification),
        ]);
    }

    public function update(Request $request, Certification $certification): RedirectResponse
    {
        $this->engine->update($request->user(), $certification, $request->all());

        return redirect()
            ->route('certifications.index')
            ->with('status', 'Certification updated successfully.');
    }

    public function destroy(Request $request, Certification $certification): RedirectResponse
    {
        $this->engine->delete($request->user(), $certification);

        return redirect()
            ->route('certifications.index')
            ->with('status', 'Certification deleted successfully.');
    }
}
