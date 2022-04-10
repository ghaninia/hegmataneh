<?php

namespace App\Models;

use App\Kernel\Enums\EnumsPortfolio;
use App\Kernel\DatabaseFilter\Scopes\HasFilterTrait;
use App\Kernel\Translation\Interfaces\TranslationableInterface;
use App\Kernel\Translation\Traits\HasTranslationTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Portfolio extends Model implements TranslationableInterface
{
    use HasFactory, HasFilterTrait, HasTranslationTrait;

    protected $fillable = [
        "user_id",
        "demo",
        "percent",
        "launched_at"
    ];

    public array $translationable = [
        EnumsPortfolio::FIELD_NAME,
        EnumsPortfolio::FIELD_SUB_NAME,
        EnumsPortfolio::FIELD_CONTENT,
        EnumsPortfolio::FIELD_EXCERPT,
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
