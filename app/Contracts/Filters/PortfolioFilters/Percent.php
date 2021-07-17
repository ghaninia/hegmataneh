<?php

namespace App\Contracts\Filters\PortfolioFilters;

use App\Core\Abstracts\QueryFilter;
use App\Core\Interfaces\FilterContract;

class Percent extends QueryFilter implements FilterContract
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
