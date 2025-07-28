<?php

namespace App\Http\Requests\Clients\Appointments;

use App\Models\Schedule;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\In;
use Illuminate\Foundation\Http\FormRequest;
use function App\Helpers\availableTimes;

class SessionStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $doctorId   = $this->input('doctor_profile_id');
        $date       = $this->input('date');
        $doctorDate = Schedule::where('doctor_profile_id' , $doctorId)->pluck('date')->toArray();
        return [
            'doctor_profile_id' => 'required|exists:doctor_profiles,id',
            'service_id'        => 'required|exists:services,id',
            'speciality_id'     => 'required|exists:specialities,id',
            'offer_id'          => 'sometimes|exists:offers,id',
            'date'              => ['required','date',Rule::in($doctorDate)],
            'time'              => ['required' , 'date_format:H:i' ,
                new In(availableTimes($doctorId,$date)->where('is_free', true)->pluck('time'))],
            'note'              => 'sometimes|string',
        ];
    }
}
