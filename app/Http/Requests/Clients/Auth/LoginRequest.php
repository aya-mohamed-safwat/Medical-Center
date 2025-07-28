<?php

namespace App\Http\Requests\Clients\Auth;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'number'   => 'required|string|regex:/^\+?[0-9]{10,15}$/',
            'password' => 'required|string|min:8',
        ];
    }
}
