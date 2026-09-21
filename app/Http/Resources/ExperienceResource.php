<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ExperienceResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'cv_id' => $this->cv_id,
            'job_title' => $this->job_title,
            'company' => $this->company,
            'location' => $this->location,
            'start_date' => format_date($this->start_date, 'Y-m-d'),
            'end_date' => format_date($this->end_date, 'Y-m-d'),
            'is_current' => $this->is_current,
            'description' => $this->description,
            'achievements' => $this->achievements,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}