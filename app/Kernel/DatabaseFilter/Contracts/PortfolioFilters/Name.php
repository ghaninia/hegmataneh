<?php

namespace App\Kernel\DatabaseFilter\Contracts\PortfolioFilters;

use App\Core\Enums\EnumsPortfolio;
use App\Kernel\DatabaseFilter\Abstracts\QueryFilter;
use App\Kernel\DatabaseFilter\Interfaces\FilterInterface;

class Name extends QueryFilter implements FilterInterface
{
    public function handle($value): void
    {
        $this->query
            ->whereHas("translations", function ($query) use ($value) {
                $query->filterBy([
                    "field" => EnumsPortfolio::FIELD_NAME,
                    "trans" => $value
                ]);
            });
    }
}
