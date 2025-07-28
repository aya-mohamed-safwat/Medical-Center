<?php

namespace App\Http\Requests\dashboard\Doctors;

use Illuminate\Foundation\Http\FormRequest;

class DoctorStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules =[
            'name'       => 'required | string',
            'email'      => 'sometimes|email|unique:users',
            'password'   => 'required | min:6 |',
            'speciality' => ['sometimes' , 'array' , 'exists:specialities,id'],
            'service'    => ['sometimes' , 'array' , 'exists:services,id'],
            'file'       => 'sometimes|file',
            'file_type'  => 'sometimes|string|in:image,pdf,medical_report,profile,offer_image,txt',

            'experience_years' => ['sometimes' , 'integer'],
            'price'            => ['sometimes' , 'integer'],
            'min'              => ['sometimes' , 'integer'],
            'max'              => ['sometimes' , 'integer'],
            'translations'     => ['sometimes', 'array'],
        ];
        foreach (config('translatable.locales') as $locale) {
            $rules["translations.$locale.bio"] = 'sometimes | string';
            $rules["translations.$locale.gender"] = 'required | string';
        }

        return $rules;
    }
}
