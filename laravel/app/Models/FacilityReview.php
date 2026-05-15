<?php

namespace App\Models;

use App\Models\User;
use App\Enums\ReviewStatus;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="FacilityReview",
 *     type="object",
 *     title="FacilityReviewモデル",
 *     description="施設の口コミ情報",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="rating", type="integer", example=3),
 *     @OA\Property(property="comment", type="string", nullable=true, example="施設の感想です。"),
 *     @OA\Property(property="created_at", type="string", format="date-time", example="2025-10-24T11:08:53Z"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", example="2025-10-24T11:08:53Z")
 * )
 * @OA\Schema(
 *     schema="FacilityReviewWithUser",
 *     allOf={
 *         @OA\Schema(ref="#/components/schemas/FacilityReview")
 *     },
 *     @OA\Property(
 *         property="user",
 *         ref="#/components/schemas/User"
 *     )
 * )
 */
class FacilityReview extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'facility_id',
        'user_id',
        'comment',
        'rating',
        'status',
    ];

    protected $casts = [
        'status' => ReviewStatus::class,
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
