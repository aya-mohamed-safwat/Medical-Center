<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Notifications\Notifiable;

class AdminProfile extends Model
{
    use notifiable;

    protected $guarded = [];

    ### Relations ###
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
