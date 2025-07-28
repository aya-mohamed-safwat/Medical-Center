<?php

namespace App\Http\Requests\dashboard\Specialties;

use Illuminate\Foundation\Http\FormRequest;

class SpecialityIndexRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'sub' => ['sometimes', 'exists:specialities,id' ,'integer'],
        ];
    }
}
