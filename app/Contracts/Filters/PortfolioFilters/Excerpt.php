<?php

namespace App\Contracts\Filters\PortfolioFilters;

use App\Core\Abstracts\QueryFilter;
use App\Core\Interfaces\FilterInterface;

class Excerpt extends QueryFilter implements FilterInterface
{
    public function handle($value): void
    {
        $this->query->where("excerpt", "like" , "%{$value}%");
    }
}
