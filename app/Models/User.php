<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Str;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'username',
        'email',
        'password',
        'is_admin',
        'is_super_admin',
        'google_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',

    ];

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function saves()
    {
        return $this->hasMany(Save::class);
    }

    public function isAdmin()
    {
        return $this->is_admin;
    }

    public function isSuperAdmin()
    {
        return $this->is_super_admin;
    }

    public function getFilamentUserNameAttribute(): string
    {
        return $this->username ?? 'Default User';
    }


    public static function boot()
    {
        parent::boot();

        static::creating(function ($user) {
            if (empty($user->username)) {
                // Generate a unique username if not provided
                $user->username = 'user_' . Str::random(8);
                while (User::where('username', $user->username)->exists()) {
                    $user->username = 'user_' . Str::random(8); // Retry if not unique
                }
            }
        });
    }


}