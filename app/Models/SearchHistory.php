<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SearchHistory extends Model
{
    protected $guarded =[];

    ### Relations ###
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
