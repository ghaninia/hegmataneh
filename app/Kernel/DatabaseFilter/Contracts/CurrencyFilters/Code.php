<?php

namespace App\Kernel\DatabaseFilter\Contracts\CurrencyFilters;

use App\Kernel\DatabaseFilter\Abstracts\QueryFilter;
use App\Kernel\DatabaseFilter\Interfaces\FilterInterface;

class Code extends QueryFilter implements FilterInterface
{
    public function handle($value): void
    {
        $this->query->where('code', $value);
    }
}
