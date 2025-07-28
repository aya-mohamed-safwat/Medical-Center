<?php

namespace App\Http\Requests\dashboard\StaticPages;

use Illuminate\Foundation\Http\FormRequest;

class StaticStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules =  [
            'slug'         => 'nullable|string|unique:static_pages,slug',
            'translations' => ['required', 'array'],
            'file'         => 'sometimes|file',
            'file_type'    => 'nullable|string',
        ];

        foreach (config('translatable.locales') as $locale) {
            $rules["translations.$locale.title"]   = ['required', 'string'];
            $rules["translations.$locale.content"] = ['required', 'string'];
        }
        return $rules;
    }
}
