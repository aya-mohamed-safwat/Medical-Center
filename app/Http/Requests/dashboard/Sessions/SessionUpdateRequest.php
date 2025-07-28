<?php

namespace App\Http\Requests\dashboard\Sessions;

use App\Models\Appointment;
use Illuminate\Foundation\Http\FormRequest;

class SessionUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'status'  => 'required|string',
        ];
    }
}
