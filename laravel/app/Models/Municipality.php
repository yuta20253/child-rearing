<?php

namespace App\Models;

use App\Models\Address;
use App\Models\Prefecture;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="Municipality",
 *     type="object",
 *     title="Municipalityモデル",
 *     description="市区町村の情報",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="prefecture_id", type="integer", example=1),
 *     @OA\Property(property="name", type="string", example="北区"),
 *     @OA\Property(property="created_at", type="string", format="date-time", example="2025-09-14T00:00:00Z"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", example="2025-09-14T00:00:00Z")
 * )
 */
class Municipality extends Model
{
    use HasFactory;

    protected $fillable = [
        'prefecture_id',
        'name'
    ];

    public function prefecture()
    {
        return $this->belongsTo(Prefecture::class);
    }

    public function addresses()
    {
        return $this->hasMany(Address::class);
    }
}
