<?php

namespace App\Http\Requests\dashboard\Schedules;

use Illuminate\Foundation\Http\FormRequest;

class ScheduleIndexRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'active' => ['sometimes','boolean'],
            'doctor' => ['sometimes','integer','exists:doctor_profiles,id'],
            'date'   => ['sometimes','date'],
        ];
    }
}
