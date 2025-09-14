<?php

namespace App\Models;

use App\Models\Prefecture;
use App\Models\Municipality;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="PostalCode",
 *     type="object",
 *     title="PostalCodeモデル",
 *     description="郵便番号の情報",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="code", type="string", example="1234567"),
 *     @OA\Property(property="municipality_id", type="integer", example=1),
 *     @OA\Property(property="town", type="string", example="王子"),
 *     @OA\Property(property="created_at", type="string", format="date-time", example="2025-09-14T00:00:00Z"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", example="2025-09-14T00:00:00Z")
 * )
 */
class PostalCode extends Model
{
    use HasFactory;

    protected $fillable = [
        'postal_code',
        'prefecture_id',
        'municipality_id',
        'town'
    ];

    public function prefecture()
    {
        return $this->belongsTo(Prefecture::class);
    }

    public function municipality()
    {
        return $this->belongsTo(Municipality::class);
    }
}
