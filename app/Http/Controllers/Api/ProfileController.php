<?php

namespace App\Http\Controllers\Api;

use App\Engines\ProfileEngine;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function __construct(protected ProfileEngine $engine) {}

    public function show(Request $request): JsonResponse
    {
        $user = $request->user();

        return response()->json([
            'success' => true,
            'message' => 'Profile retrieved successfully.',
            'data' => [
                'user' => $user,
                'completion' => $this->engine->completion($user),
            ],
        ]);
    }

    public function update(Request $request): JsonResponse
    {
        $user = $this->engine->update($request->user(), $request->all());

        return response()->json([
            'success' => true,
            'message' => 'Profile updated successfully.',
            'data' => [
                'user' => $user,
                'completion' => $this->engine->completion($user),
            ],
        ]);
    }

    public function deactivate(Request $request): JsonResponse
    {
        $this->engine->deactivate($request->user());
        Auth::logout();

        return response()->json([
            'success' => true,
            'message' => 'Your account has been deactivated successfully.',
        ]);
    }
}
