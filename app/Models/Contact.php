<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = [
        "name",
        "email",
        "phone",
        "question",
        "ip",
        "user_agent",
        "tracking_code"
    ];
}
