<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class ClientProfile extends Model
{
    protected $guarded = [];

    ### Relations ###
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }

    public function clientOffers(): HasMany
    {
        return $this->hasMany(ClientOffer::class);
    }

    public function attachment(): MorphOne
    {
        return $this->morphOne(Attachment::class, 'fileable');
    }

}
