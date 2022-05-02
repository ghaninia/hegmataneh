<?php

namespace App\Models;

use App\Kernel\Filemanager\Interfaces\FileInterface;
use App\Kernel\Uuid\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Model;
use App\Kernel\DatabaseFilter\Scopes\HasFilterTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class File extends Model implements FileInterface
{
    use HasFilterTrait, HasFactory, UuidTrait;

    protected $fillable = [
        "user_id",
        "folder_id",
        "type",
        "name",
        "path",
        "extension",
        "mime_type",
        "size",
        "driver"
    ];

    ###################
    #### RELATIONS ####
    ###################

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function folder()
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
