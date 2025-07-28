<?php

namespace App\Models;

use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class StaticPage extends Model implements TranslatableContract
{
    use Translatable;
    protected $table = 'static_pages';

    public array $translatedAttributes = ['title', 'content' ];
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
    public function scopeActive ($query , $status): void
    {
        $query->where('is_active', $status);
    }

    ### Boot ###
    public static function boot(): void
    {
        parent::boot();

        static::deleting(function ($staticPage) {
            $staticPage->attachment()->delete();
        });
    }

    ### Relations ###
    public function attachment(): MorphOne
    {
        return $this->morphOne(Attachment::class, 'fileable');
    }
}
