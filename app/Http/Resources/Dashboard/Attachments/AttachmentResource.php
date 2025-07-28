<?php

namespace App\Http\Resources\Dashboard\Attachments;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AttachmentResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'             => $this->id,
            'original_name'  => $this->original_name,
            'file_name'      => $this->file_name,
            'url'            => asset('storage/' . $this->file_path),
            'mime_type'      => $this->file_type,
            'extension'      => $this->extension,
            'size'           => round($this->size / 1024, 2) . ' KB',
            'fileable_id'    => $this->fileable_id,
            'fileable_type'  => $this->fileable_type,
            'uploaded_by'    => [
                'id'   => $this->uploaded_by_id,
                'type' => $this->uploaded_by_type,
                ]
        ];
    }
}
