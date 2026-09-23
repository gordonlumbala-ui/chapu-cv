<?php

namespace App\Http\Controllers;

use App\Engines\LanguageEngine;
use App\Models\Language;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LanguageController extends Controller
{
    public function __construct(protected LanguageEngine $engine) {}

    public function index(Request $request): View
    {
        return view('languages.index', [
            'languages' => $this->engine->listFor($request->user()),
        ]);
    }

    public function create(): View
    {
        return view('languages.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $this->engine->create($request->user(), $request->all());

        return redirect()
            ->route('languages.index')
            ->with('status', 'Language added successfully.');
    }

    public function show(Request $request, Language $language): View
    {
        return view('languages.show', [
            'language' => $this->engine->findFor($request->user(), $language),
        ]);
    }

    public function edit(Request $request, Language $language): View
    {
        return view('languages.edit', [
            'language' => $this->engine->findFor($request->user(), $language),
        ]);
    }

    public function update(Request $request, Language $language): RedirectResponse
    {
        $this->engine->update($request->user(), $language, $request->all());

        return redirect()
            ->route('languages.index')
            ->with('status', 'Language updated successfully.');
    }

    public function destroy(Request $request, Language $language): RedirectResponse
    {
        $this->engine->delete($request->user(), $language);

        return redirect()
            ->route('languages.index')
            ->with('status', 'Language deleted successfully.');
    }
}
