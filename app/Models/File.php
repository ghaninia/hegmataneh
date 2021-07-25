<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $fillable = [
        "user_id",
        "type",
        "path",
        "size",
    ];

    ###################
    #### RELATIONS ####
    ###################

    public function posts()
    {
        return $this->morphedByMany(Post::class, "fileables");
    }

    public function terms()
    {
        return $this->morphedByMany(Term::class, "fileables");
    }
}
