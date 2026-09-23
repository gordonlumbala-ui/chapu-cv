<?php

namespace App\Http\Controllers\Api;

use App\Engines\CvTemplateEngine;
use App\Http\Controllers\Controller;
use App\Http\Resources\CvTemplateResource;
use App\Models\CvTemplate;

class CvTemplateController extends Controller
{
    public function __construct(protected CvTemplateEngine $engine) {}

    public function index()
    {
        return CvTemplateResource::collection($this->engine->listActive());
    }

    public function show(CvTemplate $cvTemplate)
    {
        return new CvTemplateResource($this->engine->findActive($cvTemplate));
    }
}
