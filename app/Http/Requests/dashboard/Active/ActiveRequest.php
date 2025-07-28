<?php

namespace App\Http\Requests\dashboard\Active;

use Illuminate\Foundation\Http\FormRequest;

class ActiveRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id'    => 'required|integer',
            'model' => 'required|string|',
        ];
    }
}
