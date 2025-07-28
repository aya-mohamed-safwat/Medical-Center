<?php

namespace App\Http\Requests\dashboard\Admin\PasswordRequest;

use Illuminate\Foundation\Http\FormRequest;

class PasswordRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'old_password'     => 'required | string ',
            'new_password'     => 'required|string|min:8',
            'confirm_password' => 'required|string|min:8|same:new_password',
        ];
    }
}
