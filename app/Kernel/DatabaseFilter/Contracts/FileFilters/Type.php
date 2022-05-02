<?php

namespace App\Kernel\DatabaseFilter\Contracts\FileFilters;

use App\Kernel\DatabaseFilter\Abstracts\QueryFilter;
use App\Kernel\DatabaseFilter\Interfaces\FilterInterface;

class Type extends QueryFilter implements FilterInterface
{
    public function handle($value): void
    {
        $this->query
            ->when(
                is_array($value),
                fn ($query) => $query->whereIn("type", $value),
                fn ($query) => $query->where("type", $value),
            );
    }
}
