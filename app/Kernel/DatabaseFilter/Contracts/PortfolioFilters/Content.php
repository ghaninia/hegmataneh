<?php

namespace App\Kernel\DatabaseFilter\Contracts\PortfolioFilters;

use App\Kernel\DatabaseFilter\Abstracts\QueryFilter;
use App\Core\Enums\EnumsPortfolio;
use App\Kernel\DatabaseFilter\Interfaces\FilterInterface;

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
