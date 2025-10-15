<?php

namespace App\Models;

use App\Models\Address;
use App\Models\FacilityReview;
use App\Models\Municipality;
use App\Models\Prefecture;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="Facility",
 *     type="object",
 *     title="Facilityモデル",
 *     description="施設情報",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="name", type="string", example="北区役所"),
 *     @OA\Property(property="image", type="string", nullable=true, example=""),
 *     @OA\Property(property="latitude", type="number", format="float", example=35.6895),
 *     @OA\Property(property="longitude", type="number", format="float", example=139.6917),
 *     @OA\Property(property="equipment", type="string", example="設備情報です。"),
 *     @OA\Property(property="description", type="string", example="設備情報です。"),
 *     @OA\Property(property="address_id", type="integer", example=1),
 *     @OA\Property(property="created_at", type="string", format="date-time", example="2025-09-14T00:00:00Z"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", example="2025-09-14T00:00:00Z")
 * )
 */
class Facility extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'address_id',   // 文字列住所
        'latitude',
        'longitude',
        'equipment',
        'description',
    ];

    public function reviews()
    {
        return $this->hasMany(FacilityReview::class);
    }

    public function address()
    {
        return $this->belongsTo(Address::class);
    }

    public function municipalityRelation()
    {
        return $this->hasOneThrough(
            Municipality::class,
            Address::class,
            'municipality_id',
            'id',
            'address_id',
            'id'
        );
    }

    public function prefectureRelation()
    {
        return $this->hasOneThrough(
            Prefecture::class,
            Address::class,
            'prefecture_id',
            'id',
            'address_id',
            'id'
        );
    }

    public function municipality()
    {
        return $this->address?->municipality;
    }

    public function prefecture()
    {
        return $this->address?->municipality?->prefecture;
    }

    public function getMunicipalityIdAttribute()
    {
        return $this->address->municipality_id ?? null;
    }
}
