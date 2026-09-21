<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CertificationResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'cv_id' => $this->cv_id,
            'name' => $this->name,
            'issuing_organization' => $this->issuing_organization,
            'credential_id' => $this->credential_id,
            'credential_url' => $this->credential_url,
            'issue_date' => format_date($this->issue_date, 'Y-m-d'),
            'expiry_date' => format_date($this->expiry_date, 'Y-m-d'),
            'does_not_expire' => $this->does_not_expire,
            'description' => $this->description,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}