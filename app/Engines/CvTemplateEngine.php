<?php

namespace App\Engines;

use App\Models\CvTemplate;
use Illuminate\Database\Eloquent\Collection;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CvTemplateEngine
{
    public function listActive(): Collection
    {
        return CvTemplate::where('is_active', true)->orderBy('name')->get();
    }

    public function findActive(CvTemplate $cvTemplate): CvTemplate
    {
        if (! $cvTemplate->is_active) {
            throw new NotFoundHttpException('CV template not found.');
        }

        return $cvTemplate;
    }

    public function firstActiveId(): ?int
    {
        return CvTemplate::where('is_active', true)->orderBy('id')->value('id');
    }
}
