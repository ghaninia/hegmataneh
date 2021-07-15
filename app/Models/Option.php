<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    public $fillable = [
        "key",
        "default",
        "value"
    ];

    public $timestamps = false;
}
