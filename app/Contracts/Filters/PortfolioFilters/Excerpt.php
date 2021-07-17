<?php

namespace App\Contracts\Filters\PortfolioFilters;

use App\Core\Abstracts\QueryFilter;
use App\Core\Interfaces\FilterContract;

class Excerpt extends QueryFilter implements FilterContract
{
    public function handle($value): void
    {
        $this->query->where("excerpt", "like" , "%{$value}%");
    }
}
