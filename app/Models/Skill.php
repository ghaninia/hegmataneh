<?php

namespace App\Models;

use App\Core\Enums\EnumsSkill;
use App\Core\Traits\HasFileTrait;
use App\Core\Traits\HasSlugTrait;
use App\Core\Traits\HasFilterTrait;
use Illuminate\Database\Eloquent\Model;
use App\Core\Traits\HasTranslationTrait;
use App\Core\Interfaces\FileableInterface;
use App\Core\Interfaces\SlugableInterface;
use App\Core\Interfaces\TranslationableInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Skill extends Model implements SlugableInterface, TranslationableInterface, FileableInterface
{

    use HasFilterTrait, HasFactory, HasTranslationTrait, HasSlugTrait, HasFileTrait;

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
