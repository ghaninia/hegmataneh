<?php

namespace App\Kernel\DatabaseFilter\Contracts\SerialFilters;

use App\Kernel\DatabaseFilter\Abstracts\QueryFilter;
use App\Kernel\DatabaseFilter\Interfaces\FilterInterface;

class AmazingPrIce extends QueryFilter implements FilterInterface
{

    public function handle($value): void
    {
        $this->query->whereHas(
            "prices",
            fn ($query) => $query->where("price", $value)
        );
    }

    public function rangeHandle($values): void
    {
        foreach ($values as $value) {
            $this->query->whereHas(
                "prices",
                fn ($query) => $query->where("price", ...$value)
            );
        }
    }
}
