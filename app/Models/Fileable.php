<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Fileable extends Pivot
{
    use HasFactory;

    protected $fileable = [
        "usage" , 
        "file_id" ,
        "fileable_type" ,
        "fileable_id" ,
    ];

}
