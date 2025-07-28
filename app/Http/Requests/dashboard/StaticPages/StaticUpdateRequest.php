<?php

namespace App\Http\Requests\dashboard\StaticPages;

use Illuminate\Foundation\Http\FormRequest;

class StaticUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules =  [
            'slug'        => 'nullable|string|unique:pages,slug',
            'translations'=> ['sometimes', 'array'],
        ];

        foreach (config('translatable.locales') as $locale) {
            $rules["translations.$locale.title"] = ['sometimes', 'string'];
            $rules["translations.$locale.content"] = ['sometimes', 'string'];
        }
        return $rules;
    }
}
