<?php

namespace App\Models;

use App\Kernel\DatabaseFilter\Scopes\HasFilterTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Language extends Model
{
    use HasFactory, HasFilterTrait;

    protected $fillable = [
        "name",
        "code",
        "direction"
    ];

    public $timestamps = false;

    public function translations()
    {
        return $this->hasMany(Translation::class);
    }

    public function translators()
    {
        return $this->hasMany(Translator::class);
    }
}
