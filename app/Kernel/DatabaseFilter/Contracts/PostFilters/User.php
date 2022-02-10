<?php

namespace App\Kernel\DatabaseFilter\Contracts\PostFilters;

use App\Kernel\DatabaseFilter\Abstracts\QueryFilter;
use App\Kernel\DatabaseFilter\Interfaces\FilterInterface;

class User extends QueryFilter implements FilterInterface
{
    public function handle($value): void
    {
        $this->query->when(
            is_array($value),
            function ($query) use ($value) {
                $query->whereHas("user", fn ($query) => $query->filterBy($value));
            },
            function ($query) use ($value) {
                $query->where("user_id", $value);
            }
        );
    }
}
