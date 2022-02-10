<?php

namespace App\Kernel\DatabaseFilter\Contracts\FileFilters;

use App\Kernel\DatabaseFilter\Abstracts\QueryFilter;
use App\Kernel\DatabaseFilter\Interfaces\FilterInterface;

class User extends QueryFilter implements FilterInterface
{
    public function handle($value): void
    {
        $this->query->when(
            is_array($value),
            fn ($query) =>
            $query->whereHas("user", fn ($query) => $query->filterBy($value)),
            fn ($query) =>
            $query->where("user_id", $value)
        );
    }
}
