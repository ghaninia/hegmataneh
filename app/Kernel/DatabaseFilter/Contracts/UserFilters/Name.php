<?php

namespace App\Kernel\DatabaseFilter\Contracts\UserFilters;

use App\Kernel\DatabaseFilter\Abstracts\QueryFilter;
use App\Kernel\DatabaseFilter\Interfaces\FilterInterface;

class Name extends QueryFilter implements FilterInterface
{
    public function handle($value): void
    {
        $this->query->where('name', "like", "%{$value}%");
    }
}
