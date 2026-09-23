<?php

namespace App\Http\Controllers\Api;

use App\Engines\SkillEngine;
use App\Http\Controllers\Controller;
use App\Http\Resources\SkillResource;
use App\Models\Skill;
use Illuminate\Http\Request;

class SkillController extends Controller
{
    public function __construct(protected SkillEngine $engine) {}

    public function index(Request $request)
    {
        return SkillResource::collection($this->engine->listFor($request->user()));
    }

    public function store(Request $request)
    {
        $skill = $this->engine->create($request->user(), $request->all());

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
        return new SkillResource($this->engine->findFor($request->user(), $skill));
    }

    public function update(Request $request, Skill $skill)
    {
        $skill = $this->engine->update($request->user(), $skill, $request->all());

        return (new SkillResource($skill))->additional([
            'success' => true,
            'message' => 'Skill updated successfully.',
        ]);
    }

    public function destroy(Request $request, Skill $skill)
    {
        $this->engine->delete($request->user(), $skill);

        return response()->json([
            'success' => true,
            'message' => 'Skill deleted successfully.',
        ]);
    }
}
