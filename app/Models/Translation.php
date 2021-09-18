<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Translation extends Model
{
    use HasFactory;

    protected $fillable = [
        "language_id",
        "translationable_id",
        "translationable_type",
        "field",
        "translate"
    ];

    public function language()
    {
        return $this->belongsTo(Language::class);
    }

    public function translationable()
    {
        return $this->morphTo();
    }
}
