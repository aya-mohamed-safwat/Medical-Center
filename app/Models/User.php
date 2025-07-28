<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    protected $guarded = [];

    protected $hidden = [
        'password',
        'remember_token',
    ];


    ### Accessors ###
    public function password(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => Hash::needsRehash($value) ? Hash::make($value) : $value ,
        );
    }

    ### Scopes ###
    public function scopeActive($query , $status )
    {
        return $query->where('is_active' , $status);
    }

    public function hasPermission(String $permission): bool
    {
        return $this->role()
            ->whereHas('permissions', function ($q) use ($permission) {
                $q->where('name' , $permission);
            })->exists();
    }

    ### Relations ###
    public function routeNotificationForFcm()
    {
        return $this->fcm_token;
    }

    public function clientProfile(): HasOne
    {
        return $this->hasOne(ClientProfile::class);
    }

    public function adminProfile(): HasOne
    {
        return $this->hasOne(AdminProfile::class);
    }

    public function doctorProfile(): HasOne
    {
        return $this->hasOne(DoctorProfile::class);
    }

    public function otp(): HasMany
    {
        return $this->hasMany(Otp::class);
    }

    public function role(): BelongsTo
    {
        return $this->belongsTo(role::class);
    }

    public function favouriteDoctors(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'favorites', 'client_id', 'doctor_id')
            ->withPivot('id');
    }

    public function favoredBy(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'favorites', 'doctor_id' ,'client_id');
    }

    public function favorites(): HasMany
    {
        return $this->hasMany(Favorite::class, 'doctor_id');
    }

    public function ratedDoctors()
    {
        return $this->belongsToMany(User::class, 'comment_stars', 'client_id', 'doctor_id')
            ->withPivot('comment', 'rating')
            ->withTimestamps();
    }

    public function receivedRatings()
    {
        return $this->belongsToMany(User::class, 'comment_stars', 'doctor_id', 'client_id')
            ->withPivot('comment', 'rating')
            ->withTimestamps();
    }

    public function commentStars(): HasMany
    {
        return $this->hasMany(CommentStar::class, 'doctor_id');
    }

    public function histories(): HasMany
    {
        return $this->hasMany(SearchHistory::class);
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims(): array
    {
        return[];
    }
}
