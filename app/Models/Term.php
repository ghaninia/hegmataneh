<?php

namespace App\Models;

use App\Core\Enums\EnumsTerm;
use Illuminate\Database\Eloquent\Model;

class Term extends Model
{
    protected $fillable = [
        "name",
        "color",
        "type",
        "slug",
        "term_id",
        "file_id",
        "description",
        "demo"
    ];


    ###################
    #### RELATIONS ####
    ###################

    public function posts()
    {
        return $this->morphedByMany(Post::class, "termables");
    }

    public function picture()
    {
        return $this->belongsTo(File::class);
    }

    public function parent()
    {
        return $this->belongsTo(Term::class);
    }

    public function childerns()
    {
        return $this->hasMany(Term::class);
    }

    ################
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
