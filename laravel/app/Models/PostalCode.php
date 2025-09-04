<?php

namespace App\Models;

use App\Models\Prefecture;
use App\Models\Municipality;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostalCode extends Model
{
    use HasFactory;

    protected $fillable = [
        'postal_code',
        'prefecture_id',
        'municipality_id',
        'town'
    ];

    public function prefecture()
    {
        return $this->belongsTo(Prefecture::class);
    }

    public function municipality()
    {
        return $this->belongsTo(Municipality::class);
    }
}
