<?php

namespace App\Models;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Offer extends Model implements TranslatableContract
{
    use Translatable;

    public array $translatedAttributes = [ 'title', 'description' ];

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

    public function getDiscountedPrice($originalPrice)
    {
        if($this->discount_type === 'percentage'){
            return $originalPrice - (($originalPrice * $this->discount_value / 100));
        }
        elseif($this->discount_type === 'fixed'){
            return $originalPrice - $this->discount_value ;
        }
        return $originalPrice;
    }

    public function redirectUrl(): Attribute
    {
        return Attribute::get(function() {
            if($this->redirect_type == null){
                return [];
            }
            return match($this->redirect_type){
                'offer' => url("/api/client/doctor/{$this->redirect_id}"),
                default => '', };
        });
    }

    ### Boot ###
    public static function boot(): void
    {
        parent::boot();
        static::deleting(function ($offer) {
            $offer->attachment()->delete();
        });
    }

    ### Scopes ###
    public function scopeActive($query , $status): void
    {
        $query->where('is_active', $status);
    }

    ### Relations ###
    public function service():belongsTo
    {
        return $this->belongsTo(Service::class);
    }

    public function attachment(): MorphOne
    {
        return $this->morphOne(Attachment::class, 'fileable');
    }

    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }

    public function clientOffers(): HasMany
    {
        return $this->hasMany(ClientOffer::class);
    }

    public function speciality(): BelongsTo
    {
        return $this->belongsTo(Speciality::class);
    }

}
