<?php

namespace App\Models;

use App\Models\Address;
use App\Models\Prefecture;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
