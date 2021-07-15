<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    protected $fillable = [
        'user_ip',
        'user_id',
        'ipv4',
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
