<?php

namespace App\Kernel\DatabaseFilter\Contracts\PriceFilters;

use App\Kernel\DatabaseFilter\Abstracts\QueryFilter;
use App\Kernel\DatabaseFilter\Interfaces\FilterInterface;

class AmazingStatus extends QueryFilter implements FilterInterface
{

    public function handle($value): void
    {
        $this->query->where("status", (bool) $value );
    }
}
