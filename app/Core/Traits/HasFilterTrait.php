<?php

namespace App\Core\Traits;

use App\Models\{
    Post,
    Slug,
    Term,
    User,
    View,
    Vote,
    Skill,
    Option,
    Serial,
    Comment,
    Gateway,
    Currency,
    Language,
    Portfolio,
    Translation
};

use App\Core\Classes\FilterBuilder;

trait HasFilterTrait
{
    public function scopeFilterBy($query, $filters, $sensitiveNullValue = false)
    {
        $namespace = $this->register();
        $filter = new FilterBuilder($query, $filters, $namespace, $sensitiveNullValue);
        return $filter->apply();
    }

    public function register()
    {
        return [
            Post::class => "App\\Contracts\\Filters\\PostFilters",
            User::class => "App\\Contracts\\Filters\\UserFilters",
            View::class => "App\\Contracts\\Filters\\ViewFilters",
            Vote::class => "App\\Contracts\\Filters\\VoteFilters",
            Skill::class => "App\\Contracts\\Filters\\SkillFilters",
            Portfolio::class => "App\\Contracts\\Filters\\PortfolioFilters",
            Comment::class => "App\\Contracts\\Filters\\CommentFilters",
            Term::class => "App\\Contracts\\Filters\\TermFilters",
            Option::class => "App\\Contracts\\Filters\\OptionFilters",
            Serial::class => "App\\Contracts\\Filters\\SerialFilters",
            Language::class => "App\\Contracts\\Filters\\LanguageFilters",
            Currency::class => "App\\Contracts\\Filters\\CurrencyFilters",
            Slug::class => "App\\Contracts\\Filters\\SlugFilters",
            Translation::class => "App\\Contracts\\Filters\\TranslationFilters",
            Gateway::class =>  "App\\Contracts\\Filters\\GatewayFilters",
        ][__CLASS__] ?? null;
    }
}
