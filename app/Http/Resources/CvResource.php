<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CvResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'cv_template_id' => $this->cv_template_id,
            'title' => $this->title,
            'slug' => $this->slug,
            'cv_type' => $this->cv_type,
            'cv_type_label' => cv_type_label($this->cv_type),
            'description' => $this->description,
            'is_default' => $this->is_default,
            'is_public' => $this->is_public,
            'is_active' => $this->is_active,
            'public_url' => is_cv_public($this)
                ? cv_slug_url($this)
                : null,
            'template' => new CvTemplateResource($this->whenLoaded('template')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}