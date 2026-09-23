<?php

namespace App\Http\Controllers;

use App\Engines\CvTemplateEngine;
use App\Models\CvTemplate;
use Illuminate\View\View;

class CvTemplateController extends Controller
{
    public function __construct(protected CvTemplateEngine $engine) {}

    public function index(): View
    {
        return view('templates.index', [
            'templates' => $this->engine->listActive(),
        ]);
    }

    public function show(CvTemplate $cvTemplate): View
    {
        return view('templates.show', [
            'template' => $this->engine->findActive($cvTemplate),
        ]);
    }
}
