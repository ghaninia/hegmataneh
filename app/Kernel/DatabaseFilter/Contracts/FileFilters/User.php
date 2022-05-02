<?php

namespace App\Kernel\DatabaseFilter\Contracts\FileFilters;

use App\Kernel\DatabaseFilter\Abstracts\QueryFilter;
use App\Kernel\DatabaseFilter\Interfaces\FilterInterface;

class User extends QueryFilter implements FilterInterface
{
    public function handle($filters): void
    {
        $this->query->whereHas("user", function ($query) use ($filters) {
            $query->filterBy($filters);
        });
    }
}
