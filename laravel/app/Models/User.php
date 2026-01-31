<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Models\Address;
use App\Models\Event;
use App\Models\Facility;
use App\Notifications\CustomPasswordReset;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="User",
 *     type="object",
 *     title="Userモデル",
 *     description="ユーザー情報",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="name", type="string", example="Ririko"),
 *     @OA\Property(property="email", type="string", example="ririko@example.com"),
 *     @OA\Property(property="role", type="string", enum={"member","admin"}, example="member"),
 *     @OA\Property(property="address_id", type="integer", example=10),
 *     @OA\Property(property="created_at", type="string", format="date-time", example="2025-09-14T00:00:00Z"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", example="2025-09-14T00:00:00Z")
 * )
 */
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

    public function events()
    {
        return $this->belongsToMany(Event::class, 'user_events')
                    ->withPivot('memo')
                    ->withTimestamps()
                    ->whereNull('user_events.deleted_at');
    }

    public function facilityFavorites()
    {
        return $this->belongsToMany(Facility::class, 'facility_favorites', 'user_id', 'facility_id')->withTimestamps();
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

    public function sendPasswordResetNotification($token)
    {
        $email = $this->email;
        $this->notify(new CustomPasswordReset($token, $email));
    }
}
