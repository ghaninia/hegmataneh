<?php

namespace App\Models;

use App\Kernel\Category\Interfaces\CategoryableInterface;
use App\Kernel\Enums\EnumsTerm;
use App\Kernel\DatabaseFilter\Scopes\HasFilterTrait;
use App\Kernel\Slug\Interfaces\SlugableInterface;
use App\Kernel\Slug\Traits\HasSlugTrait;
use App\Kernel\Tag\Interfaces\TagableInterface;
use App\Kernel\Translation\Interfaces\TranslationableInterface;
use App\Kernel\Translation\Traits\HasTranslationTrait;
use Illuminate\Database\Eloquent\Model;
use App\Kernel\Basket\Interfaces\BasktableInterface;
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
