<?php

namespace App\Models;

use App\Casts\SerializeCast;
use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    public $fillable = [
        "key",
        "default",
        "value"
    ];

    protected $casts = [
        "default" => SerializeCast::class  ,
        "value" => SerializeCast::class,
    ];

    public $timestamps = false;
}
