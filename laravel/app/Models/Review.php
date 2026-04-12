<?php

namespace App\Models;

use App\Enums\ReviewStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Review extends Model
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
}
