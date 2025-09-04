<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function address()
    {
        return $this->belongsTo(Address::class);
    }

    protected static function booted()
    {
        static::deleting(function ($user) {
            $user->tokens()->delete();
        });
    }

    public function maskedName(): string
    {
        $maskedName = substr($this->name, 0, 1) . str_repeat('*', strlen($this->name) - 1);
        return $maskedName;
    }

    public function maskedEmail(): string
    {
        [$local, $domain] = explode('@', $this->email);
        $localLength = strlen($local);
        $maskedUserEmail = substr($local, 0, 2) . str_repeat('*', $localLength - 2);
        $maskedEmail = $maskedUserEmail . '@' . $domain;
        return $maskedEmail;
    }
}
