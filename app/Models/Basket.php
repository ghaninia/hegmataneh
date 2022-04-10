<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Basket extends Model
{
    use HasFactory;

    protected  $fillable = [
        "user_id" ,
        "secret_key"
    ];

    public function basketables()
    {
        return $this->hasMany(Basketable::class);
    }

    public  function user()
    {
        return $this->belongsTo(User::class) ;
    }

    public  function products()
    {
        return $this
            ->morphedByMany(Post::class , "basketable" , "basketables")
            ->withPivot("unit");
    }

    public  function serials()
    {
        return $this
            ->morphedByMany(Post::class , "basketable" , "basketables")
            ->withPivot("unit");
    }

}
