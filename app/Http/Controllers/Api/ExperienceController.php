<?php

namespace App\Http\Controllers\Api;

use App\Engines\ExperienceEngine;
use App\Http\Controllers\Controller;
use App\Http\Resources\ExperienceResource;
use App\Models\Experience;
use Illuminate\Http\Request;

class ExperienceController extends Controller
{
    public function __construct(protected ExperienceEngine $engine) {}

    public function index(Request $request)
    {
        return ExperienceResource::collection($this->engine->listFor($request->user()));
    }

    public function store(Request $request)
    {
        $experience = $this->engine->create($request->user(), $request->all());

        return (new ExperienceResource($experience))
            ->additional([
                'success' => true,
                'message' => 'Experience added successfully.',
            ])
            ->response()
            ->setStatusCode(201);
    }

    public function show(Request $request, Experience $experience)
    {
        return new ExperienceResource($this->engine->findFor($request->user(), $experience));
    }

    public function update(Request $request, Experience $experience)
    {
        $experience = $this->engine->update($request->user(), $experience, $request->all());

        return (new ExperienceResource($experience))->additional([
            'success' => true,
            'message' => 'Experience updated successfully.',
        ]);
    }

    public function destroy(Request $request, Experience $experience)
    {
        $this->engine->delete($request->user(), $experience);

        return response()->json([
            'success' => true,
            'message' => 'Experience deleted successfully.',
        ]);
    }
}
