<?php

namespace App\Models;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Discount extends Model implements TranslatableContract
{
    use Translatable;
    public array $translatedAttributes = ['description'];

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

    ### Scopes ###
    public function scopeActive($query , $status )
    {
        return $query->where('is_active' , $status);
    }

    ### Relations ###
    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    public function attachment(): MorphOne
    {
        return $this->morphOne(Attachment::class, 'fileable');
    }

    public function sliders(): HasMany
    {
        return $this->hasMany(Slider::class);
    }

}
