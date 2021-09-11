<?php

namespace App\Contracts\Filters\SerialFilters;

use App\Core\Abstracts\QueryFilter;
use App\Core\Interfaces\FilterInterface;

class Title extends QueryFilter implements FilterInterface
{

    public function handle($value): void
    {
        $this->query->whereHas(
            "price",
            fn ($query) => $query->where("price", $value)
        );
    }

    public function rangeHandle($values): void
    {
        foreach ($values as $value) {
            $this->query->whereHas(
                "price",
                fn ($query) => $query->where("price", ...$value)
            );
        }
    }
}
