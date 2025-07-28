<?php

namespace App\Http\Requests\dashboard\Offers;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class OfferStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'service_id'        => ['sometimes', 'integer','exists:services,id'],
            'speciality_id'     => ['required', 'integer','exists:specialities,id'],
            'discount_type'     => ['required', 'string',Rule::in(['fixed', 'percentage'])],
            'discount_value'    => ['required', 'integer'],
            'total_reservation' => ['required', 'integer', 'min:1'],
            'max_reservation_per_user' => ['required', 'integer', 'min:1'],
            'sessions_number'   => ['required', 'integer', 'min:1'],
            'start_time'        => ['required', 'date_format:Y-m-d H:i:s'],
            'end_time'          => ['required', 'date_format:Y-m-d H:i:s'],
            'payment_timeout'   => ['required', 'integer', 'min:1'],
            'translations'      => ['required', 'array'],
            'original_price'    => ['sometimes','integer', 'min:1'],
            'file'              => 'sometimes|file',
            'file_type'         => 'nullable|string',
            ];

            foreach (config('translatable.locales') as $locale) {
                $rules["translations.$locale.title"] = ['required', 'string'];
                $rules["translations.$locale.description"] = ['required', 'array'];
            }

        return $rules;
    }
}
