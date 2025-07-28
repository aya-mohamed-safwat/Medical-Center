<?php

namespace App\Models;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Service extends Model implements TranslatableContract
{
    use Translatable;

    public array $translatedAttributes = ['name', 'description' ];

    protected $guarded = [];

    ### Accessors ###
    public function image(): Attribute
    {
        return Attribute::get(function() {
            $attachment = $this->attachment()->latest()->first();
            return $attachment
                ? asset("storage/" . $attachment->file_path)
                : null;
        });
    }

    ### Scopes ###
    public function scopeActive($query , $status): void
    {
        $query->where('is_active', $status);
    }

    ### Boot ###
    public static function boot(): void
     {
        parent::boot();
        static::deleting(function ($model) {
            $model->attachment()->delete();
        });
     }

    ### Relations ###
    public function doctor(): BelongstoMany
    {
        return $this->belongsToMany(DoctorProfile::class,'doctor_profile_service' ,'service_id' ,'doctor_profile_id');
    }

    public function speciality(): BelongsTo
    {
        return $this->belongsTo(Speciality::class);
    }

    public function offers(): HasMany
    {
        return $this->hasMany(Offer::class);
    }

    public function attachment(): MorphOne
    {
        return $this->morphOne(Attachment::class, 'fileable');
    }

    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }

    public function discount(): HasOne
    {
        return $this->hasOne(Discount::class);
    }
}
