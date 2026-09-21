<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CvTemplateResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'preview_image' => $this->preview_image,
            'template_path' => $this->template_path,
            'is_active' => $this->is_active,
            'is_premium' => $this->is_premium,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}