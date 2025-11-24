<?php

namespace App\Models;

use App\Models\Facility;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     schema="FacilityHour",
 *     type="object",
 *     title="FacilityHourモデル",
 *     description="営業日時の情報",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="day_of_week", type="integer", example=1),
 *     @OA\Property(property="day_of_week_label", type="string", example="月曜日", description="曜日名（日本語）"),
 *     @OA\Property(property="open_time", type="string", format="time", example="09:00", description="開始時刻"),
 *     @OA\Property(property="close_time", type="string", format="time", example="18:00", description="終了時刻"),
 *     @OA\Property(property="note", type="string", example="備考"),
 *
 * )
 */
class FacilityHour extends Model
{
    use HasFactory;

    protected $fillable = [
        'facility_id',
        'day_of_week',
        'open_time',
        'close_time',
        'note',
    ];

    protected $appends = ['day_of_week_label'];

    private const DAYS_OF_WEEK = [
        0 => '日曜日',
        1 => '月曜日',
        2 => '火曜日',
        3 => '水曜日',
        4 => '木曜日',
        5 => '金曜日',
        6 => '土曜日',
    ];

    public function facility()
    {
        return $this->belongsTo(Facility::class);
    }

    public function getDayOfWeekLabelAttribute(): string
    {
        return self::DAYS_OF_WEEK[$this->day_of_week] ?? '';
    }
}
