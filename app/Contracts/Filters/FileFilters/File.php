<?php

namespace App\Contracts\Filters\FileFilters;

use App\Core\Abstracts\QueryFilter;
use App\Core\Interfaces\FilterInterface;

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
