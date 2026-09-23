<?php

namespace App\Http\Controllers\Api;

use App\Engines\CertificationEngine;
use App\Http\Controllers\Controller;
use App\Http\Resources\CertificationResource;
use App\Models\Certification;
use Illuminate\Http\Request;

class CertificationController extends Controller
{
    public function __construct(protected CertificationEngine $engine) {}

    public function index(Request $request)
    {
        return CertificationResource::collection($this->engine->listFor($request->user()));
    }

    public function store(Request $request)
    {
        $certification = $this->engine->create($request->user(), $request->all());

        return (new CertificationResource($certification))
            ->additional([
                'success' => true,
                'message' => 'Certification added successfully.',
            ])
            ->response()
            ->setStatusCode(201);
    }

    public function show(Request $request, Certification $certification)
    {
        return new CertificationResource($this->engine->findFor($request->user(), $certification));
    }

    public function update(Request $request, Certification $certification)
    {
        $certification = $this->engine->update($request->user(), $certification, $request->all());

        return (new CertificationResource($certification))->additional([
            'success' => true,
            'message' => 'Certification updated successfully.',
        ]);
    }

    public function destroy(Request $request, Certification $certification)
    {
        $this->engine->delete($request->user(), $certification);

        return response()->json([
            'success' => true,
            'message' => 'Certification deleted successfully.',
        ]);
    }
}
