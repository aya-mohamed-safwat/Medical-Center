<?php

namespace App\Http\Requests\dashboard\Doctors;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DoctorUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $userId = $this->route('doctor');

        $rules =[
            'name'       => 'sometimes',
            'email'      => ['sometimes','email',
                Rule::unique('users','email')->ignore($userId)],
            'password'   => 'sometimes',
            'role_id'    => 'sometimes',
            'speciality' => ['sometimes' , 'array' , 'exists:specialities,id'],
            'service'    => ['sometimes' , 'array' , 'exists:services,id'],
            'price'      => 'sometimes',
            'min'        => 'sometimes|integer',
            'max'        => 'sometimes|integer',

            'experience_years' => 'sometimes',
            'translations'     => ['sometimes', 'array'],
        ];
        foreach (config('translatable.locales') as $locale) {
            $rules['translations.$locale.bio'] = 'sometimes';
            $rules['translations.$locale.gender'] = 'sometimes';
        }

        return $rules;
    }
}
