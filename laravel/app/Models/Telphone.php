<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="Telphone",
 *     type="object",
 *     title="Telphoneモデル",
 *     description="電話番号",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="facility_id", type="integer", example=1),
 *     @OA\Property(property="number", type="string", example="0798772020")
 * )
 */
class Telphone extends Model
{
    use HasFactory;

    protected $fillable = [
        'facility_id',
        'number',
    ];
}
