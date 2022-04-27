<?php

namespace App\Models;

use App\Casts\SerializeCast;
use App\Kernel\DatabaseFilter\Scopes\HasFilterTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Option extends Model
{
    use HasFactory, HasFilterTrait;

    public $fillable = [
        "title",
        "key",
        "type",
        "default",
        "value"
    ];

    protected $casts = [
        "default" => SerializeCast::class,
        "value" => SerializeCast::class,
    ];

    public $timestamps = false;
}
