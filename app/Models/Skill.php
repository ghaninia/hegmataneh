<?php

namespace App\Models;

use App\Core\Traits\HasFilterTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Skill extends Model
{

    use HasFilterTrait , HasFactory ;

    protected $fillable = [
        'title_fa' ,
        'title_en' ,
        'icon'
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

    public function users()
    {
        return $this->morphedByMany( User::class , "skillable" ) ;
    }

    public function files()
    {
        return $this->morphToMany(File::class, 'fileables');
    }

}
