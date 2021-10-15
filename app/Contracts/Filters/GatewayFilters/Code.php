<?php

namespace App\Contracts\Filters\GatewayFilters;

use App\Core\Abstracts\QueryFilter;
use App\Core\Interfaces\FilterInterface;

class Code extends QueryFilter implements FilterInterface
{
    public function handle($value): void
    {
        $this->query->where('code', $value);
    }
}
