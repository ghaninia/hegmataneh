<?php

namespace App\Models;

use App\Core\Enums\EnumsTerm;
use App\Core\Traits\HasFilterTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Term extends Model
{
    use HasFilterTrait , HasFactory ;

    protected $fillable = [
        "name",
        "color",
        "type",
        "slug",
        "term_id",
        "description",
    ];

    ###################
    #### RELATIONS ####
    ###################

    public function posts()
    {
        return $this->morphedByMany(Post::class, "termables");
    }

    public function parent()
    {
        return $this->belongsTo(Term::class , "term_id" , "id");
    }

    public function childrens()
    {
        return $this->hasMany(Term::class , "term_id" , "id");
    }

    ###############
    #### SCOPES ####
    ################

    public static function scopeTags()
    {
        return self::where("type", EnumsTerm::TYPE_TAG);
    }

    public static function scopeCategories()
    {
        return self::where("type", EnumsTerm::TYPE_CATEGORY);
    }
}
