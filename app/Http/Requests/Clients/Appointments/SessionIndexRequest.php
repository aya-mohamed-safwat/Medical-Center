<?php

namespace App\Http\Requests\Clients\Appointments;

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
            'status' => ['sometimes' , 'string'],
            'name'   => ['sometimes' , 'string'],
        ];
    }
}
