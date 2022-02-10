<?php

namespace App\Kernel\DatabaseFilter\Contracts\PortfolioFilters;

use App\Kernel\DatabaseFilter\Abstracts\QueryFilter;
use App\Kernel\DatabaseFilter\Interfaces\FilterInterface;

class User extends QueryFilter implements FilterInterface
{
    public function handle($value): void
    {
        $this->query->whereHas(
            "user",
            fn ($query) => $query->filterBy($value)
        );
    }
}

