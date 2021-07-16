<?php

namespace App\Models;

use Laravel\Passport\HasApiTokens;
use App\Core\Traits\HasFilterTrait;
use Illuminate\Notifications\Notifiable;
use App\Core\Interfaces\FilterableInterface;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements FilterableInterface
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
        'picture',
        "remember_token",
        "bio"
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'role_id'
    ];

    protected $dates = [
        "deleted_at"
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

    ################
    #### SCOPES ####
    ################
    public function filterNamespace(): string
    {
        return "\\App\\Contracts\\Filters\\UserFilters";
    }
}
