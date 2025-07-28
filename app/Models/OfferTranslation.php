<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OfferTranslation extends Model
{
    public $timestamps = false;
    protected $guarded = [];

    protected $casts = [
        'description' => 'array'
    ];
}
