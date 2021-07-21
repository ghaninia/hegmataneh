<?php

namespace App\Core\Traits;

use App\Models\Post;
use App\Models\Term;
use App\Models\User;
use App\Models\View;
use App\Models\Vote;
use App\Models\Skill;
use App\Models\Comment;
use App\Models\Portfolio;
use App\Core\Classes\FilterBuilder;

trait HasFilterTrait
{
    public function scopeFilterBy($query, $filters)
    {
        $namespace = $this->register();
        $filter = new FilterBuilder($query, $filters, $namespace);
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
        ][__CLASS__] ?? null;
    }
}
