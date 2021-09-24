<?php

namespace App\Contracts\Filters\PriceFilters;

use App\Core\Abstracts\QueryFilter;
use App\Core\Interfaces\FilterInterface;

class AmazingStatus extends QueryFilter implements FilterInterface
{

    public function handle($value): void
    {
        $this->query->where("status", (bool) $value );
    }
}
