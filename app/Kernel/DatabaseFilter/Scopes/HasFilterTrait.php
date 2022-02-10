<?php

namespace App\Kernel\DatabaseFilter\Scopes;

use App\Models\File;
use App\Models\Post;
use App\Models\Slug;
use App\Models\Term;
use App\Models\User;
use App\Models\View;
use App\Models\Vote;
use App\Models\Price;
use App\Models\Skill;
use App\Models\Option;
use App\Models\Serial;
use App\Models\Comment;
use App\Models\Gateway;
use App\Models\Currency;
use App\Models\Language;
use App\Models\Portfolio;
use App\Models\Translation;
use App\Kernel\DatabaseFilter\DatabaseFilterBuilder;
use App\Kernel\DatabaseFilter\Exceptions\NotFoundModelForFilter;

trait HasFilterTrait
{
    /**
     * حساسیت بصورت دیفالت وجود ندارد
     * @param $query
     * @param array $filters
     * @param boolean $sensitiveNullValue
     */
    public function scopeFilterBy($query, array $filters, bool $sensitiveNullValue = false)
    {
        $namespace = $this->register();

        if (is_null($namespace)) {
            throw new NotFoundModelForFilter();
        }

        return
            !!$namespace ?
            (new DatabaseFilterBuilder($query, $filters, $namespace, $sensitiveNullValue))->apply() :
            $query;
    }

    public function register()
    {
        return [

            Post::class => "App\\Kernel\\DatabaseFilter\\Contracts\\PostFilters",
            User::class => "App\\Kernel\\DatabaseFilter\\Contracts\\UserFilters",
            View::class => "App\\Kernel\\DatabaseFilter\\Contracts\\ViewFilters",
            Vote::class => "App\\Kernel\\DatabaseFilter\\Contracts\\VoteFilters",
            Skill::class => "App\\Kernel\\DatabaseFilter\\Contracts\\SkillFilters",
            Portfolio::class => "App\\Kernel\\DatabaseFilter\\Contracts\\PortfolioFilters",
            Comment::class => "App\\Kernel\\DatabaseFilter\\Contracts\\CommentFilters",
            Term::class => "App\\Kernel\\DatabaseFilter\\Contracts\\TermFilters",
            Option::class => "App\\Kernel\\DatabaseFilter\\Contracts\\OptionFilters",
            Serial::class => "App\\Kernel\\DatabaseFilter\\Contracts\\SerialFilters",
            Language::class => "App\\Kernel\\DatabaseFilter\\Contracts\\LanguageFilters",
            Currency::class => "App\\Kernel\\DatabaseFilter\\Contracts\\CurrencyFilters",
            Slug::class => "App\\Kernel\\DatabaseFilter\\Contracts\\SlugFilters",
            Translation::class => "App\\Kernel\\DatabaseFilter\\Contracts\\TranslationFilters",
            Gateway::class =>  "App\\Kernel\\DatabaseFilter\\Contracts\\GatewayFilters",
            File::class =>  "App\\Kernel\\DatabaseFilter\\Contracts\\FileFilters",
            Price::class =>  "App\\Kernel\\DatabaseFilter\\Contracts\\PriceFilters",

        ][__CLASS__] ?? null;
    }
}
