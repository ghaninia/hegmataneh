<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fileable extends Model
{
    use HasFactory;

    protected $fileable = [
        "usage" ,
        "file_id" ,
        "fileable_type" ,
        "fileable_id" ,
    ];
}
