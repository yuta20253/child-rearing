<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="UserToken",
 *     type="object",
 *     title="UserTokenモデル",
 *     description="ユーザーのトークン情報",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="user_id", type="integer", example=1),
 *     @OA\Property(property="token", type="string", example="eyJhbGciOiJI..."),
 *     @OA\Property(property="expire_at", type="string", format="date-time", example="2025-09-14T00:00:00Z"),
 *     @OA\Property(property="created_at", type="string", format="date-time", example="2025-09-14T00:00:00Z"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", example="2025-09-14T00:00:00Z")
 * )
 */
class UserToken extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'token',
        'expire_at'
    ];
}
