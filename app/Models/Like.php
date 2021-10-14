<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    protected $fillable = [
        'ipv4',
        'user_id',
        'like',
        'unlike'
    ];


    ###################
    #### RELATIONS ####
    ###################

    public function likeable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
