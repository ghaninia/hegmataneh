<?php

namespace App\Models;

use App\Core\Traits\HasFilterTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Gateway extends Model
{
    use HasFactory, HasFilterTrait;

    protected $casts = [
        "status" => "boolean"
    ];

    protected $fillable = [
        "status",
        "name",
        "code",
    ];

    public function currencies()
    {
        return $this->belongsToMany(Currency::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
