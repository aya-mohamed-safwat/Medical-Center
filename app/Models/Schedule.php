<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Schedule extends Model
{
    protected $guarded = [];

    ### Scopes ###
    public function scopeActive($query , $status): void
    {
        $query->where('is_active', $status);
    }

    ### Relation ###
    public function doctorProfile(): BelongsTo
    {
        return $this->belongsTo(DoctorProfile::class);
    }
}
