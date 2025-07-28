<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Report extends Model
{
    protected $guarded = [];

    ### Boot ###
    public static function boot(): void
    {
        parent::boot();
        static::deleting(function ($report) {
            $report->attachment()->delete();
        });
    }

    ### Relations ###
    public function attachment(): MorphMany
    {
        return $this->morphMany(Attachment::class, 'fileable');
    }

    public function appointment(): BelongsTo
    {
        return $this->belongsTo(Appointment::class);
    }
}
