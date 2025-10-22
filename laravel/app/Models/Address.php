<?php

namespace App\Models;

use App\Models\Facility;
use App\Models\Municipality;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="Address",
 *     type="object",
 *     title="Addressモデル",
 *     description="町域の情報",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="municipality_id", type="integer", example=1),
 *     @OA\Property(property="postal_code", type="string", example="1234567"),
 *     @OA\Property(property="town", type="string", nullable=true, example=""),
 *     @OA\Property(property="chome", type="string", nullable=true ),
 *     @OA\Property(property="banchi", type="string", nullable=true ),
 *     @OA\Property(property="go", type="string", nullable=true ),
 *     @OA\Property(property="building", type="string", nullable=true ),
 *     @OA\Property(property="room", type="string", nullable=true ),
 *     @OA\Property(property="created_at", type="string", format="date-time", example="2025-09-14T00:00:00Z"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", example="2025-09-14T00:00:00Z")
 * )
 * @OA\Schema(
 *     schema="AddressWithRelations",
 *     allOf={
 *         @OA\Schema(ref="#/components/schemas/Address"),
 *         @OA\Schema(
 *             @OA\Property(property="municipality", ref="#/components/schemas/MunicipalityWithPrefecture")
 *         )
 *     }
 * )
 */
class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'municipality_id',
        'town',
        'chome',
        'banchi',
        'go',
        'building',
        'room',
        'postal_code'
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function facilities()
    {
        return $this->hasMany(Facility::class);
    }

    public function municipality()
    {
        return $this->belongsTo(Municipality::class);
    }

    public function postalCodes()
    {
        return $this->hasMany(PostalCode::class);
    }
}
