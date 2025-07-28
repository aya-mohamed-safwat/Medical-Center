<?php

namespace App\Http\Requests\dashboard\Schedules;

use Illuminate\Foundation\Http\FormRequest;

class AvailableTimesRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'doctor_id'   => 'required|exists:doctor_profiles,id',
            'date' => 'required|date',
        ];
    }
}
