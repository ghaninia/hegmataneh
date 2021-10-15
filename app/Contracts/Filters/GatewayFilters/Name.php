<?php

namespace App\Contracts\Filters\GatewayFilters;

use App\Core\Abstracts\QueryFilter;
use App\Core\Interfaces\FilterInterface;

class Name extends QueryFilter implements FilterInterface
{
    public function handle($value): void
    {
        $this->query->where('gateways.name', "like", "%{$value}%");
    }
}
