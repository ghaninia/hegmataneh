<?php

namespace App\Kernel\DatabaseFilter\Contracts\PriceFilters;

use App\Kernel\DatabaseFilter\Abstracts\QueryFilter;
use App\Kernel\DatabaseFilter\Interfaces\FilterInterface;

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
