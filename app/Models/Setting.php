<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $guarded = [];

    public function scopeActive($query): void
    {
        $query->where('is_active', 1);
    }
}
