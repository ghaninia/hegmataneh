<?php

namespace App\Kernel\DatabaseFilter\Contracts\FileFilters;

use App\Kernel\DatabaseFilter\Abstracts\QueryFilter;
use App\Kernel\DatabaseFilter\Interfaces\FilterInterface;

class File extends QueryFilter implements FilterInterface
{
    public function handle($value): void
    {
        $this->query->when(
            is_array($value),
            fn ($query) =>
            $query->whereHas("parent", fn ($query) => $query->filterBy($value)),
            fn ($query) =>
            $query->where("file_id", $value)
        );
    }
}
