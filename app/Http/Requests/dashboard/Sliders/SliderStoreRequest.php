<?php

namespace App\Http\Requests\dashboard\Sliders;

use Illuminate\Foundation\Http\FormRequest;

class SliderStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'discount_id'   => 'sometimes|nullable|integer|exists:discounts,id',
            'type'          => 'sometimes|string',
            'order'         => 'nullable|integer|min:0',
            'start_at'      => 'nullable|date',
            'end_at'        => 'nullable|date|after_or_equal:start_at',
            'redirect_type' => 'sometimes|nullable|string',
            'redirect_id'   => 'sometimes|nullable|integer',

            'file' => 'sometimes|file',
            'file_type' => 'nullable|string',

        ];

        foreach (config('translatable.locales') as $locale) {
            $rules["translations.$locale.title"] = ['required', 'string'];
            $rules["translations.$locale.description"] = ['required','array'];
        }
        return $rules;
    }
}
