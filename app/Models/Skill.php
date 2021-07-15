<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    protected $fillable = [
        'title_fa' ,
        'title_en' ,
        'icon' ,
        'svg'
    ] ;


    ###################
    #### RELATIONS ####
    ###################

    public function portfolios()
    {
        return $this->morphedByMany( Portfolio::class , "skillable" ) ;
    }

    public function posts()
    {
        return $this->morphedByMany( Post::class , "skillable" ) ;
    }

}
