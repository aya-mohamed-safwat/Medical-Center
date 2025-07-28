<?php

namespace App\Rules;

use App\Enums\BookingStatus;
use App\Models\Appointment;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use function App\Helpers\availableTimes;

class ValidTime implements ValidationRule
{
    public function __construct(protected $appointmentId , protected $doctorProfileId , protected $date){ }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $exists = Appointment::where('doctor_profile_id', $this->doctorProfileId)
            ->where('date', $this->date)
            ->where('time', $value)
            ->whereNotIn('status', [BookingStatus::Cancelled, BookingStatus::Completed])
            ->when($this->appointmentId, fn($q) => $q->where('id','!=', $this->appointmentId))
            ->exists();

        if (!$exists) {
            return;
        }

        if(!in_array($value, availableTimes($this->doctorProfileId, $this->date)))
        {
            $fail("The time provided is not valid.");
        }
    }
}
