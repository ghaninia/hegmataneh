<?php

namespace App\Models;

use App\Casts\UuidCast;
use App\Kernel\DatabaseFilter\Scopes\HasFilterTrait;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFilterTrait;

    protected $fillable = [
        "id",
        "user_id",
        "folder_id",
        "type",
        "name",
        "path",
        "extension",
        "mime_type",
        "size",
    ];

    protected $casts = [
        "id" => UuidCast::class,
    ];

    ###################
    #### RELATIONS ####
    ###################

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
