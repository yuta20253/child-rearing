<?php

namespace App\Models;

use App\Models\Municipality;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prefecture extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    public function municipalities()
    {
        return $this->hasMany(Municipality::class);
    }

    public function postalCodes()
    {
        return $this->hasMany(PostalCode::class);
    }
}
