<?php

namespace App\Models;

use App\Core\Traits\HasFileTrait;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use App\Core\Interfaces\FileableInterface;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Kernel\DatabaseFilter\Scopes\HasFilterTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements FileableInterface
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes, HasFilterTrait , HasFileTrait;

    protected $fillable = [
        'name',
        'status',
        'role_id',
        'email',
        'mobile',
        "username",
        'password',
        "remember_token",
        "bio",
        "verified_at",
        "currency_id",
        "language_id"
    ];

    protected $hidden = [
        'password',
    ];

    protected $dates = [
        "deleted_at",
        "verified_at"
    ];

    protected $casts = [
        "status" => "boolean"
    ];


    public function role()
    {
        return $this->belongsTo(Role::class, "role_id");
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function posts()
    {
        return $this->hasMany(Post::class, "user_id");
    }

    public function comments()
    {
        return $this->hasMany(Comment::class, "user_id");
    }

    public function portfolios()
    {
        return $this->hasMany(Portfolio::class);
    }

    public function views()
    {
        return $this->hasMany(View::class);
    }

    public function votes()
    {
        return $this->hasMany(Vote::class);
    }

    public function serials()
    {
        return $this->hasMany(Vote::class);
    }

    public function skills()
    {
        return $this->morphToMany(Skill::class, "skillable");
    }

    public  function basket()
    {
        return $this->hasOne(Basket::class)->withDefault();
    }

    public function language()
    {
        return $this->belongsTo(Language::class);
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }
}
