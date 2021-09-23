<?php

namespace App\Contracts\Filters\PostFilters;

use App\Core\Enums\EnumsPost;
use App\Core\Abstracts\QueryFilter;
use App\Core\Interfaces\FilterInterface;

class GoalPost extends QueryFilter implements FilterInterface
{
    public function handle($value): void
    {
        $this->query
            ->whereHas("translations", function ($query) use ($value) {
                $query->filterBy([
                    "field" => EnumsPost::FIELD_GOAL_POST ,
                    "trans" => $value
                ]);
            });
    }
}
