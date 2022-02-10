<?php

namespace App\Kernel\DatabaseFilter\Contracts\PortfolioFilters;

use App\Kernel\DatabaseFilter\Abstracts\QueryFilter;
use App\Kernel\DatabaseFilter\Interfaces\FilterInterface;

class Percent extends QueryFilter implements FilterInterface
{
    public function handle($value): void
    {
        $this->query->where("percent", $value);
    }

    public function rangeHandle($values): void
    {
        foreach ($values as $value) {
            $this->query->where('percent', ...$value);
        }
    }
}
