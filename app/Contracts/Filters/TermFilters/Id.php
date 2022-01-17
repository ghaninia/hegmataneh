<?php

namespace App\Contracts\Filters\TermFilters;

use App\Core\Abstracts\QueryFilter;
use App\Core\Interfaces\FilterInterface;

class Id extends QueryFilter implements FilterInterface
{
    public function handle($value): void
    {
        $this->query->where('ID', $value);
    }
}
