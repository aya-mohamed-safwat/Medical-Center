<?php

namespace App\Http\Requests\dashboard\Attachments;

use Illuminate\Foundation\Http\FormRequest;

class FileStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
                 'file'          => 'required|file',
                 'fileable_id'   => 'required|integer',
                 'fileable_type' => 'required|string',
                 'file_type'     => 'nullable|string|',
        ];
    }
}
