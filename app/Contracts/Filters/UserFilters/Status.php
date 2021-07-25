<?php

namespace App\Contracts\Filters\UserFilters;

use App\Core\Abstracts\QueryFilter;
use App\Core\Interfaces\FilterInterface;

class Status extends QueryFilter implements FilterInterface
{
    public function handle($value): void
    {
        $this->query->where('status', $value);
    }
}
