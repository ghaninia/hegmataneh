<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    protected $fillable = [
        "type",
        "base_path",
        "image_name",
        "user_id",
        'thumb_dir',
        'format'
    ];

    ###################
    #### RELATIONS ####
    ###################

    public function posts()
    {
        return $this->morphedByMany(Post::class, "fileables");
    }

    // public function categories()
    // {
    //     return $this->hasMany(Term::class, 'file_id', "id");
    // }

    // public function thumbnails()
    // {
    //     return $this->hasMany(Post::class, "file_id", 'id');
    // }

    // public function quotations()
    // {
    //     return $this->hasMany(Quotation::class, "file_id", 'id');
    // }
}
