<?php

namespace App\Contracts\Filters\GatewayFilters;

use App\Core\Abstracts\QueryFilter;
use App\Core\Interfaces\FilterInterface;

class Currencies extends QueryFilter implements FilterInterface
{
    public function handle($value): void
    {
        $this->query->whereHas("currencies", fn ($query) => $query->filterBy($value));
    }
}
