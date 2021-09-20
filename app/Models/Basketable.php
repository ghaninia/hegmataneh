<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Support\Str;

class Basketable extends Pivot
{
    protected $table = "basketables" ;

    protected $fillable = [
        "id" ,
        "basket_id" ,
        "basketable_id" ,
        "basketable_type" ,
        "unit" ,
    ];

    public function basket()
    {
        return $this->belongsTo(Basket::class) ;
    }

    public static function boot()
    {
        parent::boot();
        static::creating(function($item){
            $item->id = Str::uuid() ;
        });
    }

}
