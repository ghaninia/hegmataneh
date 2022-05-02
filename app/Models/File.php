<?php

namespace App\Models;

use App\Kernel\Uuid\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Model;
use App\Kernel\DatabaseFilter\Scopes\HasFilterTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class File extends Model
{
    use HasFilterTrait, HasFactory, UuidTrait;

    protected $fillable = [
        "user_id",
        "folder_id",
        "type",
        "name",
        "relpath",
        "extension",
        "mime_type",
        "size",
    ];

    ###################
    #### RELATIONS ####
    ###################

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function parent()
    {
        return $this->belongsTo(File::class, "folder_id");
    }

    public function childrens()
    {
        return $this->hasMany(File::class, "folder_id");
    }

    public function fileables()
    {
        return $this->hasMany(Fileable::class, "file_id", "id");
    }

    public function posts()
    {
        return $this->morphedByMany(Post::class, "fileable");
    }

    public function terms()
    {
        return $this->morphedByMany(Term::class, "fileable");
    }

    public function skills()
    {
        return $this->morphedByMany(Skill::class, "fileable");
    }
}
