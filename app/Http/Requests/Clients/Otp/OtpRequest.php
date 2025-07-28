<?php

namespace App\Http\Requests\Clients\Otp;

use Illuminate\Foundation\Http\FormRequest;

class OtpRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'number' => 'required|string|regex:/^\+?[0-9]{10,15}$/',
            "code"   => "required|string",
        ];
    }
}
