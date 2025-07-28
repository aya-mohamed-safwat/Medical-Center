<?php

namespace App\Http\Requests\dashboard\Services;

use Illuminate\Foundation\Http\FormRequest;

class ServiceStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'speciality_id' => ['required', 'integer', 'exists:specialities,id'],
            'doctor_id'     => ['required', 'integer', 'exists:doctor_profiles,id'],
            'translations'  => ['required', 'array'],
            'file'          => 'sometimes|file',
            'file_type'     => 'sometimes|string|in:image,pdf,medical_report,profile,offer_image,txt',
        ];

        foreach (config('translatable.locales') as $locale) {
            $rules["translations.$locale"]      = ['required', 'array'];
            $rules["translations.$locale.name"] = ['required', 'string'];
            $rules["translations.$locale.description"] = ['required','array'];
        }
        return $rules ;
    }
}
