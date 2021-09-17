<?php

namespace App\Models;

use App\Core\Enums\EnumsPost;
use App\Core\Enums\EnumsTerm;
use App\Core\Traits\HasFilterTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use SoftDeletes, HasFactory, HasFilterTrait;

    protected $fillable = [
        "type",
        "status",
        "user_id",
        "comment_status",
        "vote_status",
        "format",
        "development",
        "title",
        "goal_post",
        "slug",
        "content",
        "excerpt",
        "faq",
        "theme",
        "published_at",
        "deleted_at"
    ];

    protected $dates = [
        "deleted_at",
        "published_at"
    ];

    protected $casts = [
        "vote_status" => "boolean" ,
        "comment_status" => "boolean" ,
        "deleted_at" => "datetime" ,
        "published_at" => "datetime" ,
    ];

    ###################
    #### RELATIONS ####
    ###################

    public function productInformation()
    {
        return $this->hasOne(ProductInformation::class);
    }

    public function price()
    {
        return $this->morphOne(Price::class , "priceable") ;
    }


    public function episodes()
    {
        return $this
            ->belongsToMany(Serial::class)
            ->withPivot([
                "title",
                "description",
                "is_locked",
                "priority",
            ]);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function files()
    {
        return $this->morphToMany(File::class, 'fileables');
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
        return $this->hasMany(Vote::class);
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
        return $this->morphToMany(Term::class, 'termables');
    }

    public function tags()
    {
        return $this->morphToMany(Term::class, 'termables')
            ->wherePivot("type", EnumsTerm::TYPE_TAG);
    }

    public function categories()
    {
        return $this->morphToMany(Term::class, 'termables')
            ->wherePivot("type", EnumsTerm::TYPE_CATEGORY);
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
