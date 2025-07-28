<?php

namespace App\Http\Requests\Clients\Appointments;

use App\Rules\ValidTime;
use Illuminate\Foundation\Http\FormRequest;

class SessionUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $appointment = $this->route('appointment');
        return [
            'date' => 'sometimes|date',
            'time' => [
                'sometimes',
                'date_format:H:i',
                new validTime($appointment->id ,
                    $appointment->doctor_profile_id ,
                    $this->input('date') ?? $appointment?->date ,
                )
            ],
            'note' => 'nullable|string',
        ];
    }
}

// custom notification channels
//http request from server to server
//roles - permission
