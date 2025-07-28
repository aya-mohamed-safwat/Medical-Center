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
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class DoctorProfile extends Model implements TranslatableContract
{
    use Translatable;

    protected $table = 'doctor_profiles';
    public array $translatedAttributes = ['bio','gender'];
    protected $guarded = [];

    ### Accessors ###
    public function image(): Attribute
    {
        return Attribute::get(function(){
            $attachment = $this->attachment()->latest()->first();
            return $attachment
                ? asset("storage/" . $attachment->file_path)
                : null;
        });
    }

    ### Scopes ###
    public function scopeActive($query , $status ){
        return $query->where('is_active' , $status);
    }

    ### Boot ###
    public static function boot(): void
    {
        parent::boot();
        static::deleting(function ($model) {
            $model->attachment()->delete();
            $model->certificate()->delete();
        });
    }

    ### Relations ###
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function specialities(): BelongstoMany
    {
        return $this->belongsToMany(Speciality::class);
    }

    public function services(): BelongstoMany
    {
        return $this->belongsToMany(Service::class);
    }

    public function attachment(): MorphOne
    {
        return $this->morphOne(Attachment::class, 'fileable');
    }

    public function certificates(): MorphMany
    {
        return $this->morphMany(Attachment::class, 'fileable')
            ->where('file_type','certificate' );
    }

    public function translation(): HasOne
    {
        return $this->hasOne(DoctorProfileTranslation::class) ->where('locale', app()->getLocale());
    }

    public function schedules(): HasMany
    {
        return $this->hasMany(Schedule::class);
    }

    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }

}
