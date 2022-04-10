<?php

namespace App\Models;

use App\Kernel\DatabaseFilter\Scopes\HasFilterTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class View extends Model
{
    use HasFilterTrait , HasFactory;

    protected $fillable = [
        'viewable_id',
        'viewable_type',
        'user_id',
        'ipv4',
        "created_at"
    ];

    ###################
    #### RELATIONS ####
    ###################

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function viewable()
    {
        return $this->morphTo();
    }

}
