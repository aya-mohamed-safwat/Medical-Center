<?php

namespace App\Http\Requests\Users;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'sometimes|string',
            'email' => 'sometimes|email|unique:users',
            'password' => 'sometimes',
            'role_id' => 'sometimes'
        ];
    }
}
