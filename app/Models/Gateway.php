<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Gateway extends Model
{
    use HasFactory;

    protected $fillable = [
        "key",
        "name",
        "currency_id",
    ];

    public function currency()
    {
        return $this->belongsTo(Currency::class) ;
    }

    public function orders()
    {
        return $this->hasMany(Order::class) ;
    }

}
