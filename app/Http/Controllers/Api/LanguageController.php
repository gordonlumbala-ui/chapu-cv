<?php

namespace App\Http\Controllers\Api;

use App\Engines\LanguageEngine;
use App\Http\Controllers\Controller;
use App\Http\Resources\LanguageResource;
use App\Models\Language;
use Illuminate\Http\Request;

class LanguageController extends Controller
{
    public function __construct(protected LanguageEngine $engine) {}

    public function index(Request $request)
    {
        return LanguageResource::collection($this->engine->listFor($request->user()));
    }

    public function store(Request $request)
    {
        $language = $this->engine->create($request->user(), $request->all());

        return (new LanguageResource($language))
            ->additional([
                'success' => true,
                'message' => 'Language added successfully.',
            ])
            ->response()
            ->setStatusCode(201);
    }

    public function show(Request $request, Language $language)
    {
        return new LanguageResource($this->engine->findFor($request->user(), $language));
    }

    public function update(Request $request, Language $language)
    {
        $language = $this->engine->update($request->user(), $language, $request->all());

        return (new LanguageResource($language))->additional([
            'success' => true,
            'message' => 'Language updated successfully.',
        ]);
    }

    public function destroy(Request $request, Language $language)
    {
        $this->engine->delete($request->user(), $language);

        return response()->json([
            'success' => true,
            'message' => 'Language deleted successfully.',
        ]);
    }
}
