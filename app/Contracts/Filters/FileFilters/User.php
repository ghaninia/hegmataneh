<?php

namespace App\Contracts\Filters\FileFilters;

use App\Core\Abstracts\QueryFilter;
use App\Core\Interfaces\FilterInterface;

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
