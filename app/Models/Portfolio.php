<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Portfolio extends Model
{
    use HasFactory ;

    protected $fillable = [
        "user_id",
        "file_id",
        "name",
        "description",
        "demo",
        "excerpt",
        "percent",
        "started_at"
    ];

    protected $dates = [
        "started_at"
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
