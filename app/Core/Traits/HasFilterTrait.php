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
    File,
    Language,
    Portfolio,
    Price,
    Translation
};

use App\Core\Classes\FilterBuilder;

trait HasFilterTrait
{
    public function scopeFilterBy($query, array|string $filters = [], $sensitiveNullValue = false)
    {
        $namespace = $this->register();
        $filter = new FilterBuilder($query, $filters, $namespace, $sensitiveNullValue);
        return $filter->apply();
    }

    public function locationFilters(): array
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
            File::class =>  "App\\Contracts\\Filters\\FileFilters",
            Price::class =>  "App\\Contracts\\Filters\\PriceFilters",
        ];
    }

    public function register()
    {
        return $this->locationFilters()[__CLASS__] ?? null;
    }
}
