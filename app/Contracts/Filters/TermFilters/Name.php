<?php

namespace App\Contracts\Filters\TermFilters;

use App\Core\Abstracts\QueryFilter;
use App\Core\Interfaces\FilterContract;

class Name extends QueryFilter implements FilterContract
{
    public function handle($value): void
    {
        $this->query->where('name', "like", "%{$value}%");
    }
}
