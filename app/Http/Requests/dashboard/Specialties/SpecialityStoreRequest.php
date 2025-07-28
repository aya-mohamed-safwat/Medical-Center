<?php

namespace App\Http\Requests\dashboard\Specialties;

use Illuminate\Foundation\Http\FormRequest;

class SpecialityStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'parent_id'    => 'sometimes|nullable',
            'translations' => 'required|array',
            'file'         => 'sometimes|file',
            'file_type'    => 'sometimes|string',
        ];

        foreach (config('translatable.locales') as $locale) {
            $rules["translations.$locale.name"] = 'required | string';
        }
        return $rules;
    }
}
