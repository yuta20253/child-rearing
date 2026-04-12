<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="Event",
 *     type="object",
 *     title="Eventモデル",
 *     description="Event情報",
 *     required={"id", "facility_id", "title", "start_datetime", "end_datetime"},
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="facility_id", type="integer", example=1),
 *     @OA\Property(property="title", type="string", example="読み聞かせ会"),
 *     @OA\Property(property="start_datetime", type="string", format="date-time", example="2025-09-14T00:00:00Z"),
 *     @OA\Property(property="end_datetime", type="string", format="date-time", example="2025-09-14T00:00:00Z"),
 *     @OA\Property(property="capacity", type="integer", example=20),
 *     @OA\Property(property="deleted_at", type="string", format="date-time", nullable=true, example=null),
 *     @OA\Property(property="created_at", type="string", format="date-time", example="2025-09-14T00:00:00Z"),
 *     @OA\Property(property="updated_at", type="string", format="date-time", example="2025-09-14T00:00:00Z"),
 * )
 */
class Event extends Model
{
    use HasFactory;

    public function facility()
    {
        return $this->belongsTo((Facility::class));
    }
}
