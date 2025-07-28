<?php

namespace App\Http\Requests\dashboard\Services;

use Illuminate\Foundation\Http\FormRequest;

class ServiceUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'speciality_id' => ['sometimes', 'required', 'integer', 'exists:specialities,id'],
            'is_active'     => ['sometimes', 'boolean'],
            'translations'  => ['sometimes', 'array'],
        ];
        foreach (config('translatable.locales') as $locale) {
            $rules["translatable.$locale.name"] = ['sometimes', 'string'];
            $rules["translatable.$locale.description"] = ['sometimes', 'array'];
        }
        return $rules ;
    }
}
