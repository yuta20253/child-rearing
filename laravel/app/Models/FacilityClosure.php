<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FacilityClosure extends Model
{
    use HasFactory;

    protected $fillable = [
        'facility_id ',
        'closed_date',
        'reason',
    ];
}
