<?php

namespace App\Http\Controllers\Api;

use App\Engines\MobileCvSyncEngine;
use App\Http\Controllers\Controller;
use App\Http\Resources\CvResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MobileCvController extends Controller
{
    public function __construct(protected MobileCvSyncEngine $engine) {}

    public function show(Request $request): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => 'Mobile CV loaded successfully.',
            'data' => $this->engine->loadForMobile($request->user()),
        ]);
    }

    public function sync(Request $request): JsonResponse
    {
        $result = $this->engine->sync($request->user(), $request->all());

        return response()->json([
            'success' => true,
            'message' => 'CV synced successfully.',
            'data' => [
                'user' => $result['user'],
                'cv' => new CvResource($result['cv']),
                'mobile' => $this->engine->loadForMobile($result['user']),
                'completion' => $result['completion'],
                'cv_completion' => $result['cv_completion'],
            ],
        ]);
    }
}
