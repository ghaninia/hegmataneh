<?php

namespace App\Models;

use App\Core\Traits\HasFilterTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Serial extends Model
{
    use HasFactory, HasFilterTrait;

    protected $fillable = [
        "user_id",
        "title",
        "description",
    ];

    public function episodes()
    {
        return $this->hasMany(PostSerial::class, "serial_id");
    }

    public function posts()
    {
        return $this
            ->belongsToMany(Post::class)
            ->withPivot([
                "title",
                "description",
                "is_locked",
                "priority",
            ]);
    }

    public function price()
    {
        return $this->morphOne(Price::class, "priceable");
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
