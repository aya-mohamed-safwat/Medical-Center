<?php

namespace App\Http\Requests\dashboard\Discounts;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DiscountUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'service_id'     => ['sometimes', 'integer' ,'exists:services,id'],
            'discount_type'  => ['sometimes', 'string',Rule::in(['fixed', 'percentage'])],
            'discount_value' => ['sometimes', 'integer'],
            'start_time'     => ['sometimes', 'date_format:Y-m-d H:i:s'],
            'end_time'       => ['sometimes', 'date_format:Y-m-d H:i:s','after_or_equal:start_time'],
            'translations'   => ['sometimes', 'array'],
        ];

        foreach (config('translatable.locales') as $locale) {
            $rules["translations.$locale.description"] = ['sometimes', 'array'];
        }
        return $rules;
    }
}
