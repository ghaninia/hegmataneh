<?php

namespace App\Models;

use App\Core\Enums\EnumsFile;
use App\Core\Enums\EnumsTerm;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use SoftDeletes;

    protected $fillable = [
        "type",
        "user_id",
        "file_id",
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
        "price",
        "sale_price",
        "maximum_sell",
        "expire_day",
        "download_limit",
        "sale_price_dates_from",
        "sale_price_dates_to",
        "attachment_id",
        "technology",
        "attachment_id",
        "published_at"
    ];

    protected $guarded = [
        "type",
        "price"
    ];

    protected $dates = [
        "deleted_at",
        "sale_price_dates_from",
        "sale_price_dates_to",
        "published_at"
    ];

    protected $hidden = [
        'user_id',
        'price',

        "price",
        "sale_price",
        "maximum_sell",
        "expire_day",
        "download_limit",
        "sale_price_dates_from",
        "sale_price_dates_to",

        "user_id",
        "file_id",
        "comment_status",
        "vote_status",
        "format",
        "development",
    ];

    ###################
    #### RELATIONS ####
    ###################

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function files()
    {
        return $this->morphToMany(File::class, 'fileables');
    }

    public function pictures()
    {
        return $this->morphToMany(File::class, 'fileables')->wherePivot("format", EnumsFile::TYPE_IMAGE);
    }

    public function attachments()
    {
        return $this->morphToMany(File::class, 'fileables')->wherePivot("format", EnumsFile::TYPE_FILE);
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
        return $this->morphToMany(Term::class, 'termables')->wherePivot("type", EnumsTerm::TYPE_TAG);
    }

    public function categories()
    {
        return $this->morphToMany(Term::class, 'termables')->wherePivot("type", EnumsTerm::TYPE_CATEGORY);
    }
}
