<?php

namespace App\Contracts\Filters\PriceFilters;

use App\Core\Abstracts\QueryFilter;
use App\Core\Interfaces\FilterInterface;

class Price extends QueryFilter implements FilterInterface
{

    public function handle($value): void
    {
        $this->query->where("price", $value);
    }

    public function rangeHandle($values): void
    {
        foreach ($values as $value) {
            $this->query->where("price", ...$value);
        }
    }
}
