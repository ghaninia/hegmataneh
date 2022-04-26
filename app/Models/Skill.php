<?php

namespace App\Models;

use App\Kernel\Enums\EnumsSkill;
use Illuminate\Database\Eloquent\Model;
use App\Kernel\Slug\Traits\HasSlugTrait;
use App\Kernel\Slug\Interfaces\SlugableInterface;
use App\Kernel\DatabaseFilter\Scopes\HasFilterTrait;
use App\Kernel\Translation\Traits\HasTranslationTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Kernel\Translation\Interfaces\TranslationableInterface;

class Skill extends Model implements SlugableInterface, TranslationableInterface
{

    use HasFilterTrait, HasFactory, HasTranslationTrait, HasSlugTrait;

    protected $fillable = [
        'icon'
    ];

    public $with = [
        "translations",
        "slugs",
        "files"
    ];

    public string $slugable = EnumsSkill::FIELD_NAME;

    public array $translationable = [
        EnumsSkill::FIELD_NAME,
        EnumsSkill::FIELD_DESCRIPTION
    ];

    ###################
    #### RELATIONS ####
    ###################

    public function portfolios()
    {
        return $this->morphedByMany(Portfolio::class, "skillable");
    }

    public function posts()
    {
        return $this->morphedByMany(Post::class, "skillable");
    }

    public function users()
    {
        return $this->morphedByMany(User::class, "skillable");
    }
}
