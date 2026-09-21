<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CvTemplateResource;
use App\Models\CvTemplate;
use Illuminate\Http\Request;

class CvTemplateController extends Controller
{
    public function index()
    {
        $templates = CvTemplate::where('is_active', true)
            ->orderBy('name')
            ->get();

        return CvTemplateResource::collection($templates);
    }

    public function show(CvTemplate $cvTemplate)
    {
        if (! $cvTemplate->is_active) {
            return response()->json([
                'success' => false,
                'message' => 'CV template not found.',
            ], 404);
        }

        return new CvTemplateResource($cvTemplate);
    }
}