<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class View extends Model
{
    protected $fillable = [
        'viewable_id',
        'viewable_type',
        'user_id',
        'user_ip',
        'marked'
    ];


    ###################
    #### RELATIONS ####
    ###################

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function post()
    {
        return $this->belongsTo(Post::class, "viewable_id", "id");
    }

    public function viewable()
    {
        return $this->morphTo();
    }
}
