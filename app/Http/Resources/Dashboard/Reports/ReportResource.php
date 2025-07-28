<?php

namespace App\Http\Resources\Dashboard\Reports;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReportResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'        => $this->id,
            'session'   => $this->appointment_id,
            'image'     => $this->attachment->first()->file_path
                ? asset("storage/" . $this->attachment->first()->file_path)
                : null,
            'size'      =>  round($this->attachment->first()->size / 1024, 2) . ' KB',
            'name'      => $this->attachment->first()->original_name ?? null,
            'file_type' => $this->attachment->first()->file_type ?? null,
        ];
    }
}
