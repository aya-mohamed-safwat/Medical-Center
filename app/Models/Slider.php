<?php

namespace App\Models;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Slider extends Model implements TranslatableContract
{
    use Translatable;

    public array $translatedAttributes = ['title', 'description' ];
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

    public function getRedirectUrl(): array|string
    {
        if($this->redirect_type == null){
            return [];
        }
        return match($this->redirect_type){
            'doctor' => url("/api/client/doctor/{$this->redirect_id}"),
            default => '', };
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
        static::deleting(function ($slider) {
            $slider->attachment()->delete();
        });
    }

    ### Relations ###
    public function attachment(): MorphOne
    {
        return $this->morphOne(Attachment::class, 'fileable');
    }

    public function discount(): BelongsTo
    {
        return $this->belongsTo(Discount::class);
    }
}
