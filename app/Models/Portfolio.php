<?php

namespace App\Models;

use App\Core\Traits\HasFilterTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Portfolio extends Model
{
    use HasFactory , HasFilterTrait ;

    protected $fillable = [
        "user_id",
        "name",
        "description",
        "demo",
        "excerpt",
        "percent",
        "launched_at"
    ];

    protected $dates = [
        "launched_at"
    ];

    ###################
    #### RELATIONS ####
    ###################

    public function skills()
    {
        return $this->morphToMany(Skill::class, "skillable");
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function views()
    {
        return $this->morphMany(View::class, "viewable");
    }
}
