<?php

namespace App\Contracts\Filters\PortfolioFilters;

use App\Core\Enums\EnumsPortfolio;
use App\Core\Abstracts\QueryFilter;
use App\Core\Interfaces\FilterInterface;

class SubName extends QueryFilter implements FilterInterface
{
    public function handle($value): void
    {
        $this->query
            ->whereHas("translations", function ($query) use ($value) {
                $query->filterBy([
                    "field" => EnumsPortfolio::FIELD_SUB_NAME,
                    "trans" => $value
                ]);
            });
    }
}
