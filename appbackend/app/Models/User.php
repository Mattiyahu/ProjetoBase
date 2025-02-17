<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'full_name',
        'email',
        'password',
        'google_id',
        'avatar',
        'has_completed_questionnaire',
        'registration_ip',
        'registration_source',
        'preferences',
        'last_login_at'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'google_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'has_completed_questionnaire' => 'boolean',
        'last_login_at' => 'datetime',
        'preferences' => 'json',
    ];

    /**
     * Get the user's full name.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($user) {
            $user->name = trim($user->first_name . ' ' . $user->last_name);
            $user->full_name = $user->name;
        });

        static::updating(function ($user) {
            if ($user->isDirty(['first_name', 'last_name'])) {
                $user->name = trim($user->first_name . ' ' . $user->last_name);
                $user->full_name = $user->name;
            }
        });
    }
}
