<?php

namespace App\Kernel\DatabaseFilter\Contracts\TermFilters;

use App\Kernel\DatabaseFilter\Abstracts\QueryFilter;
use App\Kernel\DatabaseFilter\Interfaces\FilterInterface;

class Slug extends QueryFilter implements FilterInterface
{
    public function handle($value): void
    {
        $this->query->whereHas("slugs", function ($query) use ($value) {
            $query->filterBy([
                "slug" => $value
            ]);
        });
    }
}
