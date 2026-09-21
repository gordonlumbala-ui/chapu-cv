<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'cv_id' => $this->cv_id,
            'name' => $this->name,
            'role' => $this->role,
            'description' => $this->description,
            'technologies' => $this->technologies,
            'url' => $this->url,
            'github_url' => $this->github_url,
            'start_date' => format_date($this->start_date, 'Y-m-d'),
            'end_date' => format_date($this->end_date, 'Y-m-d'),
            'is_current' => $this->is_current,
            'display_order' => $this->display_order,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}