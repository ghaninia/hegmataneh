<?php

namespace App\Models;

use App\Core\Enums\EnumsTerm;
use App\Core\Traits\HasSlugTrait;
use App\Core\Traits\HasFilterTrait;
use Illuminate\Database\Eloquent\Model;
use App\Core\Traits\HasTranslationTrait;
use App\Core\Interfaces\TagableInterface;
use App\Core\Interfaces\SlugableInterface;
use App\Core\Interfaces\BasktableInterface;
use App\Core\Interfaces\CategoryableInterface;
use App\Core\Interfaces\TranslationableInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Serial extends Model implements
    BasktableInterface,
    CategoryableInterface,
    TranslationableInterface,
    SlugableInterface,
    TagableInterface
{
    use
        HasFactory,
        HasFilterTrait,
        HasTranslationTrait,
        HasSlugTrait;

    protected $fillable = [
        "user_id",
    ];

    public string $slugable = "title";

    public array $translationable = [
        "title",
        "description",
    ];

    public $with = [
        "translations",
        "slugs",
    ];

    ###################
    #### RELATIONS ####
    ###################

    public function episodes()
    {
        return $this->hasMany(Episode::class, "serial_id");
    }

    public function posts()
    {
        return $this
            ->belongsToMany(Post::class, "episodes")
            ->withPivot([
                "is_locked",
                "priority",
            ]);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function prices()
    {
        return $this->morphMany(Price::class, "priceable");
    }

    public function baskets()
    {
        return $this->morphToMany(Basket::class, "basketable", "basketables");
    }


    public function tags()
    {
        return $this->morphToMany(Term::class, 'termable')
            ->wherePivot("type", EnumsTerm::TYPE_TAG);
    }

    public function categories()
    {
        return $this->morphToMany(Term::class, 'termable')
            ->wherePivot("type", EnumsTerm::TYPE_CATEGORY);
    }
}
