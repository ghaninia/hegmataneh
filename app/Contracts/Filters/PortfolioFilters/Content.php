<?php

namespace App\Contracts\Filters\PortfolioFilters;

use App\Core\Abstracts\QueryFilter;
use App\Core\Enums\EnumsPortfolio;
use App\Core\Interfaces\FilterInterface;

class Content extends QueryFilter implements FilterInterface
{
    public function handle($value): void
    {
        $this->query
            ->whereHas("translations", function ($query) use ($value) {
                $query->filterBy([
                    "field" => EnumsPortfolio::FIELD_CONTENT,
                    "trans" => $value
                ]);
            });
    }
}
