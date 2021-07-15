<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    protected $fillable = [
        'name' ,
        "content" ,
        'place' ,
    ];

    protected $casts = [
        'content' => "array"
    ] ;

    public $timestamps = false ;

}
