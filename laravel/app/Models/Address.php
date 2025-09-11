<?php

namespace App\Models;

use App\Models\Facility;
use App\Models\Municipality;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'municipality_id',
        'town',
        'chome',
        'banchi',
        'go',
        'building',
        'room',
        'postal_code'
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function facility()
    {
        return $this->hasMany(Facility::class);
    }

    public function municipality()
    {
        return $this->belongsTo(Municipality::class);
    }

    public function postalCodes()
    {
        return $this->hasMany(PostalCode::class);
    }
}
