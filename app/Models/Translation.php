<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Translation extends Model
{
    use HasFactory;

    protected $fillable = [
        "translationable_id",
        "translationable_type",
        "field"
    ];

    public function translationable()
    {
        return $this->morphTo();
    }
}
