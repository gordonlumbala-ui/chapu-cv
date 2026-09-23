<?php

namespace App\Http\Controllers\Api;

use App\Engines\CvEngine;
use App\Http\Controllers\Controller;
use App\Http\Resources\CvResource;
use App\Models\Cv;
use Illuminate\Http\Request;

class CvController extends Controller
{
    public function __construct(protected CvEngine $engine) {}

    public function index(Request $request)
    {
        return CvResource::collection($this->engine->listFor($request->user()));
    }

    public function store(Request $request)
    {
        $cv = $this->engine->create($request->user(), $request->all());

        return (new CvResource($cv))
            ->additional([
                'success' => true,
                'message' => 'CV created successfully.',
            ])
            ->response()
            ->setStatusCode(201);
    }

    public function show(Request $request, Cv $cv)
    {
        return new CvResource($this->engine->findFor($request->user(), $cv));
    }

    public function update(Request $request, Cv $cv)
    {
        $cv = $this->engine->update($request->user(), $cv, $request->all());

        return (new CvResource($cv))->additional([
            'success' => true,
            'message' => 'CV updated successfully.',
        ]);
    }

    public function destroy(Request $request, Cv $cv)
    {
        $this->engine->delete($request->user(), $cv);

        return response()->json([
            'success' => true,
            'message' => 'CV deleted successfully.',
        ]);
    }
}
