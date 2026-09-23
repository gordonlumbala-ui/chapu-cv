<?php

namespace App\Http\Controllers\Api;

use App\Engines\EducationEngine;
use App\Http\Controllers\Controller;
use App\Http\Resources\EducationResource;
use App\Models\Education;
use Illuminate\Http\Request;

class EducationController extends Controller
{
    public function __construct(protected EducationEngine $engine) {}

    public function index(Request $request)
    {
        return EducationResource::collection($this->engine->listFor($request->user()));
    }

    public function store(Request $request)
    {
        $education = $this->engine->create($request->user(), $request->all());

        return (new EducationResource($education))
            ->additional([
                'success' => true,
                'message' => 'Education added successfully.',
            ])
            ->response()
            ->setStatusCode(201);
    }

    public function show(Request $request, Education $education)
    {
        return new EducationResource($this->engine->findFor($request->user(), $education));
    }

    public function update(Request $request, Education $education)
    {
        $education = $this->engine->update($request->user(), $education, $request->all());

        return (new EducationResource($education))->additional([
            'success' => true,
            'message' => 'Education updated successfully.',
        ]);
    }

    public function destroy(Request $request, Education $education)
    {
        $this->engine->delete($request->user(), $education);

        return response()->json([
            'success' => true,
            'message' => 'Education deleted successfully.',
        ]);
    }
}
