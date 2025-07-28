<?php

namespace App\Models;

use App\Enums\BookingStatus;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Appointment extends Model
{
    protected $guarded = [];

    protected $casts = ['status' => BookingStatus::class,];

    ### Scopes ###
    public function scopeActive($query): void
    {
        $query->whereNotIn('status', [BookingStatus::Cancelled])
            ->whereBetween('date', [Carbon::parse($query->time),
                (Carbon::parse($query->time)->addMinutes($query->duration)->toDateTimeString())]);
    }

    ### Relations ###
    public function doctor(): BelongsTo
    {
        return $this->belongsTo(DoctorProfile::class,'doctor_profile_id');
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(ClientProfile::class , 'client_profile_id');
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    public function offer(): BelongsTo
    {
        return $this->belongsTo(Offer::class);
    }

    public function speciality(): BelongsTo
    {
        return $this->belongsTo(Speciality::class);
    }

    public function clientOffer(): BelongsTo
    {
        return $this->belongsTo(ClientOffer::class);
    }

    public function reports(): HasMany
    {
        return $this->hasMany(Report::class);
    }
}
