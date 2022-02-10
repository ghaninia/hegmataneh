<?php

namespace App\Kernel\DatabaseFilter\Contracts\TermFilters;

use App\Kernel\DatabaseFilter\Abstracts\QueryFilter;
use App\Kernel\DatabaseFilter\Interfaces\FilterInterface;

class Id extends QueryFilter implements FilterInterface
{
    public function handle($value): void
    {
        $this->query->where('ID', $value);
    }
}
