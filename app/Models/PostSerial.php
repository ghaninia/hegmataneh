<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PostSerial extends Pivot
{
    use HasFactory ;

    protected $fillable = [
        "post_id",
        "serial_id",
        "title",
        "is_locked",
        "priority",
        "description"
    ];

    public $timestamps = false ;

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
