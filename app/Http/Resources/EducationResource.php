<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EducationResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'cv_id' => $this->cv_id,
            'education_level' => $this->education_level,
            'institution' => $this->institution,
            'program' => $this->program,
            'field_of_study' => $this->field_of_study,
            'start_date' => format_date($this->start_date, 'Y-m-d'),
            'end_date' => format_date($this->end_date, 'Y-m-d'),
            'grade' => $this->grade,
            'certificate' => $this->certificate,
            'description' => $this->description,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}