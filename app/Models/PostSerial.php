<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class PostSerial extends Pivot
{
    protected $fillable = [
        "post_id",
        "serial_id",
        "title",
        "is_locked",
        "priority",
        "description"
    ];

    protected $casts = [
        "is_locked" => "boolean"
    ];

    public function serial()
    {
        return $this->belongsTo(Serial::class);
    }

    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
