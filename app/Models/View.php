<?php

namespace App\Models;

use App\Core\Traits\HasFilterTrait;
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
