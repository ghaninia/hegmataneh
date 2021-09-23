<?php

namespace App\Models;

use App\Core\Traits\HasFilterTrait;
use Illuminate\Database\Eloquent\Model;
use App\Core\Traits\HasTranslationTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Translation extends Model
{
    use HasFactory, HasTranslationTrait , HasFilterTrait;

    protected $fillable = [
        "language_id",
        "translationable_id",
        "translationable_type",
        "field",
        "trans"
    ];

    public $timestamps = false;

    protected $with = ["language"];

    public function translationable()
    {
        return $this->morphTo();
    }

    public function language()
    {
        return $this->belongsTo(Language::class);
    }
}
