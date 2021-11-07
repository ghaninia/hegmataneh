<?php

namespace App\Contracts\Filters\FileFilters;

use App\Core\Abstracts\QueryFilter;
use App\Core\Interfaces\FilterInterface;

class Name extends QueryFilter implements FilterInterface
{
    public function handle($value): void
    {
        $this->query->where("name", "like", "%{$value}%");
    }
}
