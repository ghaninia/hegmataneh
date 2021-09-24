<?php

namespace App\Contracts\Filters\PostFilters;

use App\Core\Enums\EnumsPost;
use App\Core\Abstracts\QueryFilter;
use App\Core\Interfaces\FilterInterface;

class Price extends QueryFilter implements FilterInterface
{
    public function handle($value): void
    {
        $this->query
            ->whereHas("prices", function ($query) use ($value) {
                $query->filterBy([
                    "price" => $value
                ]);
            });
    }
}
