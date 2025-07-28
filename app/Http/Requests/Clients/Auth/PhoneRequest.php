<?php

namespace App\Http\Requests\Clients\Auth;

use Illuminate\Foundation\Http\FormRequest;

class PhoneRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'number' => 'required|unique:users,number|string',
        ];
    }
}
