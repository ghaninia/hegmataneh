<?php

namespace App\Models;

use App\Core\Traits\HasFilterTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Currency extends Model
{
    use HasFactory, HasFilterTrait;

    protected $fillable = [
        "name",
        "code"
    ];

    public $timestamps = false;

    public function prices()
    {
        return $this->hasMany(Price::class);
    }

    public function gateways()
    {
        return $this->belongsToMany(Gateway::class);
    }
}
