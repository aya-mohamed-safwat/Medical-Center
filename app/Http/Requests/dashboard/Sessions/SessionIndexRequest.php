<?php

namespace App\Http\Requests\dashboard\Sessions;

use Illuminate\Foundation\Http\FormRequest;

class SessionIndexRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'doctorId' => 'sometimes|integer|exists:doctor_profiles,id',
            'clientId' => 'sometimes|integer|exists:client_profiles,id',
            'status'   => 'sometimes|string',
        ];
    }
}
