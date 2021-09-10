<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Serial extends Model
{
    use HasFactory;

    protected $fillable = [
        "title",
        "description",
    ];


    public function posts()
    {
        return $this
            ->belongsToMany(Post::class)
            ->withTimestamps()
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
}
