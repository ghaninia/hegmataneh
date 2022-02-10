<?php

namespace App\Models;

use App\Core\Enums\EnumsPortfolio;
use App\Kernel\DatabaseFilter\Scopes\HasFilterTrait;
use Illuminate\Database\Eloquent\Model;
use App\Core\Traits\HasTranslationTrait;
use App\Core\Interfaces\TranslationableInterface;
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
