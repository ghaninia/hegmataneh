<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    use HasFactory;

    protected $fillable = [
        "name",
        "code"
    ];

    protected $timestamps = false;

    public function prices()
    {
        return $this->hasMany(Price::class);
    }
}
