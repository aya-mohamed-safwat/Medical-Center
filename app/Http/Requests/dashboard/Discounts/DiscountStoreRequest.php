<?php

namespace App\Http\Requests\dashboard\Discounts;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DiscountStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {

        $rules = [
            'service_id'     => ['required', 'integer' , 'exists:services,id'],
            'discount_type'  => ['required', 'string' ,Rule::in(['fixed', 'percentage'])],
            'discount_value' => ['required', 'integer'],
            'start_time'     => ['required', 'date_format:Y-m-d H:i:s'],
            'end_time'       => ['required', 'date_format:Y-m-d H:i:s','after_or_equal:start_time'],
            'file'           => 'sometimes|file',
            'file_type'      => 'sometimes|nullable|string',
            'translations'   => ['required', 'array'],
        ];

        foreach (config('translatable.locales') as $locale) {
            $rules["translations.$locale.description"] = ['required', 'array'];
        }
        return $rules;
    }
}
