<?php

namespace App\Models;

use App\Models\Address;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Facility extends Model
{
    use HasFactory, SoftDeletes;

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

    public function municipality()
    {
        return $this->hasOneThrough(
            Municipality::class,
            Address::class,
            'municipality_id', // addresses.municipality_id → municipalities.id
            'id',          // municipalities.id
            'address_id',  // facilities.address_id
            'id'          // addresses.id
        );
    }

    public function prefecture()
    {
        return optional($this->municipality)->prefecture;
    }
}
