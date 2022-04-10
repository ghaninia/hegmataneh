<?php

namespace App\Models;

use App\Kernel\Category\Interfaces\CategoryableInterface;
use App\Kernel\Enums\EnumsPost;
use App\Kernel\Enums\EnumsTerm;
use App\Kernel\Slug\Interfaces\SlugableInterface;
use App\Kernel\Slug\Traits\HasSlugTrait;
use App\Kernel\Tag\Interfaces\TagableInterface;
use App\Kernel\Translation\Interfaces\TranslationableInterface;
use App\Kernel\Translation\Traits\HasTranslationTrait;
use App\Kernel\UploadCenter\Interfaces\FileableInterface;
use App\Kernel\UploadCenter\Traits\HasFileTrait;
use App\Kernel\View\Interfaces\ViewableInterface;
use App\Kernel\Vote\Interfaces\VoteableInterface;
use Illuminate\Database\Eloquent\Model;
use App\Kernel\Basket\Interfaces\BasktableInterface;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Kernel\DatabaseFilter\Scopes\HasFilterTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model implements
    CategoryableInterface,
    TranslationableInterface,
    FileableInterface,
    BasktableInterface,
    SlugableInterface,
    ViewableInterface,
    VoteableInterface,
    TagableInterface
{

    use
        SoftDeletes,
        HasFactory,
        HasFilterTrait,
        HasTranslationTrait,
        HasSlugTrait,
        HasFileTrait;

    protected $fillable = [
        "type",
        "status",
        "user_id",
        "comment_status",
        "vote_status",
        "format",
        "development",
        "theme",
        "published_at",
        "deleted_at"
    ];

    protected $dates = [
        "deleted_at",
        "published_at"
    ];

    protected $casts = [
        "vote_status" => "boolean",
        "comment_status" => "boolean",
        "deleted_at" => "datetime",
        "published_at" => "datetime",
    ];

    public $with = [
        "translations",
        "slugs",
        "files"
    ];

    public string $slugable = EnumsPost::FIELD_TITLE;

    public array $translationable = [
        EnumsPost::FIELD_TITLE,
        EnumsPost::FIELD_FAQ,
        EnumsPost::FIELD_GOAL_POST,
        EnumsPost::FIELD_CONTENT,
        EnumsPost::FIELD_EXCERPT,
    ];

    ###################
    #### RELATIONS ####
    ###################

    public function productInformation()
    {
        return $this->hasOne(ProductInformation::class);
    }

    public function prices()
    {
        return $this->morphMany(Price::class, "priceable");
    }

    public function episodes()
    {
        return $this
            ->belongsToMany(Serial::class, "episodes")
            ->withPivot([
                "is_locked",
                "priority",
            ]);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function skills()
    {
        return $this->morphToMany(Skill::class, "skillable");
    }

    public function views()
    {
        return $this->morphMany(View::class, "viewable");
    }

    public function votes()
    {
        return $this->morphMany(Vote::class, "voteable");
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function terms()
    {
        return $this->morphToMany(Term::class, 'termable');
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

    public function baskets()
    {
        return $this->morphToMany(Basket::class, "basketable", "basketables");
    }

    ###############
    #### SCOPES ####
    ################

    public static function scopePages($query)
    {
        return $query->where("type", EnumsPost::TYPE_PAGE);
    }

    public static function scopePosts($query)
    {
        return $query->where("type", EnumsPost::TYPE_POST);
    }

    public static function scopeProducts($query)
    {
        return $query->where("type", EnumsPost::TYPE_PRODUCT);
    }
}
