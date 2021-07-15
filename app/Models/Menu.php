<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $fillable =
    [
        "name",
        "content",
        "place"
    ];

    public $casts = [
        "content" => "array"
    ];
}
