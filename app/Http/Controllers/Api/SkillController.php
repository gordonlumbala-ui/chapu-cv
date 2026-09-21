<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\SkillResource;
use App\Models\Skill;
use Illuminate\Http\Request;

class SkillController extends Controller
{
    public function index(Request $request)
    {
        $skills = $request->user()
            ->skills()
            ->orderBy('category')
            ->orderBy('name')
            ->get();

        return SkillResource::collection($skills);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'category' => ['nullable', 'string', 'max:255'],
            'level' => ['nullable', 'string', 'max:255'],
            'percentage' => ['nullable', 'integer', 'min:0', 'max:100'],
        ]);

        $skill = $request->user()
            ->skills()
            ->create($validated);

        return (new SkillResource($skill))
            ->additional([
                'success' => true,
                'message' => 'Skill added successfully.',
            ])
            ->response()
            ->setStatusCode(201);
    }

    public function show(Request $request, Skill $skill)
    {
        if ($skill->user_id !== $request->user()->id) {
            return response()->json([
                'success' => false,
                'message' => 'Skill not found.',
            ], 404);
        }

        return new SkillResource($skill);
    }

    public function update(Request $request, Skill $skill)
    {
        if ($skill->user_id !== $request->user()->id) {
            return response()->json([
                'success' => false,
                'message' => 'Skill not found.',
            ], 404);
        }

        $validated = $request->validate([
            'name' => ['sometimes', 'required', 'string', 'max:255'],
            'category' => ['nullable', 'string', 'max:255'],
            'level' => ['nullable', 'string', 'max:255'],
            'percentage' => ['nullable', 'integer', 'min:0', 'max:100'],
        ]);

        $skill->update($validated);

        return (new SkillResource($skill))
            ->additional([
                'success' => true,
                'message' => 'Skill updated successfully.',
            ]);
    }

    public function destroy(Request $request, Skill $skill)
    {
        if ($skill->user_id !== $request->user()->id) {
            return response()->json([
                'success' => false,
                'message' => 'Skill not found.',
            ], 404);
        }

        $skill->delete();

        return response()->json([
            'success' => true,
            'message' => 'Skill deleted successfully.',
        ]);
    }
}