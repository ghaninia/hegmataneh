<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Core\Traits\HasTranslationTrait;
use App\Core\Interfaces\TranslationableInterface;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Episode extends Model implements TranslationableInterface
{
    
    use HasFactory, HasTranslationTrait;

    protected $fillable = [
        "post_id",
        "serial_id",
        "is_locked",
        "priority",
    ];

    public $timestamps = false;

    protected $casts = [
        "is_locked" => "boolean"
    ];

    public array $translationable = [
        "title",
        "description",
    ];

    public $with = [
        "translations",
    ];

    public function serial()
    {
        return $this->belongsTo(Serial::class);
    }

    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
