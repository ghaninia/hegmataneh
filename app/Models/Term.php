<?php

namespace App\Models;

use App\Core\Enums\EnumsTerm;
use App\Core\Traits\HasSlugTrait;
use App\Core\Traits\HasFilterTrait;
use Illuminate\Database\Eloquent\Model;
use App\Core\Traits\HasTranslationTrait;
use App\Core\Interfaces\SlugableInterface;
use App\Core\Interfaces\TranslationableInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Term extends Model implements SlugableInterface , TranslationableInterface
{
    use HasFilterTrait, HasFactory , HasTranslationTrait , HasSlugTrait ;

    protected $fillable = [
        "name",
        "color",
        "type",
        "slug",
        "term_id",
        "description",
    ];

    public $with = [
        "translations",
        "slugs",
    ];

    public string $slugable = EnumsTerm::FIELD_NAME ;

    public array $translationable = [
        EnumsTerm::FIELD_NAME ,
        EnumsTerm::FIELD_DESCRIPTION
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
        return $this->belongsTo(Term::class, "term_id", "id");
    }

    public function childrens()
    {
        return $this->hasMany(Term::class, "term_id", "id");
    }

    public function files()
    {
        return $this->morphToMany(File::class, "fileables");
    }

    ###############
    #### SCOPES ####
    ################

    public static function scopeTags($query)
    {
        return $query->where("type", EnumsTerm::TYPE_TAG);
    }

    public static function scopeCategories($query)
    {
        return $query->where("type", EnumsTerm::TYPE_CATEGORY);
    }
}
