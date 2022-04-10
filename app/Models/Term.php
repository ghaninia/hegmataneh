<?php

namespace App\Models;

use App\Kernel\Enums\EnumsTerm;
use App\Kernel\Slug\Interfaces\SlugableInterface;
use App\Kernel\Slug\Traits\HasSlugTrait;
use App\Kernel\Translation\Interfaces\TranslationableInterface;
use App\Kernel\Translation\Traits\HasTranslationTrait;
use App\Kernel\UploadCenter\Interfaces\FileableInterface;
use App\Kernel\UploadCenter\Traits\HasFileTrait;
use Illuminate\Database\Eloquent\Model;
use App\Kernel\DatabaseFilter\Scopes\HasFilterTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Term extends Model implements SlugableInterface, TranslationableInterface, FileableInterface
{
    use HasFilterTrait, HasFactory, HasTranslationTrait, HasSlugTrait, HasFileTrait;

    protected $fillable = [
        "name",
        "color",
        "type",
        "slug",
        "term_id",
        "description",
    ];

    public string $slugable = EnumsTerm::FIELD_NAME;

    public array $translationable = [
        EnumsTerm::FIELD_NAME,
        EnumsTerm::FIELD_DESCRIPTION
    ];

    public $with = [
        "slugs" ,
        "files" ,
        "translations"
    ];

    ###################
    #### RELATIONS ####
    ###################

    public function posts()
    {
        return $this->morphedByMany(Post::class, "termable");
    }

    public function parent()
    {
        return $this->belongsTo(Term::class, "term_id", "id");
    }

    public function childrens()
    {
        return $this->hasMany(Term::class, "term_id", "id");
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
