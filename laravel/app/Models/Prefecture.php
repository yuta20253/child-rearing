<?php

namespace App\Models;

use App\Models\Municipality;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="Prefecture",
 *     type="object",
 *     title="Prefectureモデル",
 *     description="都道府県の情報",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="name", type="string", example="東京都"),
 *     @OA\Property(property="created_at", type="string", format="date-time", example="2025-09-14T00:00:00Z"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", example="2025-09-14T00:00:00Z")
 * )
 */
class Prefecture extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    public function municipalities()
    {
        return $this->hasMany(Municipality::class);
    }

    public function postalCodes()
    {
        return $this->hasMany(PostalCode::class);
    }
}
