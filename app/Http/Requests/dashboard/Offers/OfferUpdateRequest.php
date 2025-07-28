<?php

namespace App\Http\Requests\dashboard\Offers;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class OfferUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
        'service_id'         => ['sometimes', 'integer', 'exists:services,id'],
        'speciality_id'      => ['required', 'integer','exists:specialities,id'],
        'discount_type'      => ['sometimes', 'string',Rule::in(['fixed', 'percentage'])],
        'discount_value'     => ['sometimes', 'integer'],
        'total_reservations' => ['sometimes', 'integer', 'min:1'],
        'max_reservations'   => ['sometimes', 'integer', 'min:1'],
        'start_date'         => ['sometimes', 'date_format:Y-m-d H:i:s'],
        'end_date'           => ['sometimes', 'date_format:Y-m-d H:i:s'],
        'original_price'     => ['integer', 'min:1'],
        'translations'       => ['sometimes', 'array'],
    ];

        foreach (config('translatable.locales') as $locale) {
            $rules["translations.$locale.title"] = ['sometimes', 'string'];
            $rules["translations.$locale.description"] = ['sometimes', 'array'];
        }

        return $rules;
    }
}
