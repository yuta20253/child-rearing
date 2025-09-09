<?php

namespace App\Models;

use App\Models\Address;
use App\Models\Municipality;
use App\Models\Prefecture;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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
        return $this->address->municipality;
    }

    public function prefecture()
    {
        return $this->address->municipality->prefecture;
    }
}
