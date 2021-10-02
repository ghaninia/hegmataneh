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
        "ipv4",
        "user_agent",
        "tracking_code"
    ];
}
