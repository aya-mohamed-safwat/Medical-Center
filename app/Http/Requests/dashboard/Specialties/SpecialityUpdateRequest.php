<?php

namespace App\Http\Requests\dashboard\Specialties;

use Illuminate\Foundation\Http\FormRequest;

class SpecialityUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'parent_id'    => 'sometimes|nullable',
            'translations' => 'sometimes|array',
        ];

        foreach (config('translatable.locales') as $locale) {
            $rules["translations.$locale.name"] = 'sometimes | string';
        }
        return $rules;
    }
}
