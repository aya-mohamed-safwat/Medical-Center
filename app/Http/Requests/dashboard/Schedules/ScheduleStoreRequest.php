<?php

namespace App\Http\Requests\dashboard\Schedules;

use Illuminate\Foundation\Http\FormRequest;

class ScheduleStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'doctor_profile_id' => 'required|integer|exists:doctor_profiles,id',
            'date'      => 'required|date_format:Y-m-d',
            'from'      => 'required|date_format:H:i:s',
            'to'        => 'required|date_format:H:i:s|after:from',
        ];
    }
}
