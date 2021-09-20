<?php

namespace App\Models;

use Laravel\Passport\HasApiTokens;
use App\Core\Traits\HasFilterTrait;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes, HasFilterTrait;

    protected $fillable = [
        'name',
        'status',
        'role_id',
        'email',
        'mobile',
        "username",
        'password',
        "remember_token",
        "bio" ,
        "verified_at"
    ];

    protected $hidden = [
        'password',
    ];

    protected $dates = [
        "deleted_at" ,
        "verified_at"
    ];

    protected $casts = [
        "status" => "boolean"
    ];

    public function files()
    {
        return $this->morphToMany(File::class, 'fileables');
    }

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
        return $this->hasMany(View::class) ;
    }

    public function votes()
    {
        return $this->hasMany(Vote::class) ;
    }

    public function serials()
    {
        return $this->hasMany(Vote::class) ;
    }

    public function skills()
    {
        return $this->morphToMany(Skill::class, "skillable");
    }

    public  function basket()
    {
        return $this->hasOne(Basket::class)->withDefault();
    }

}
