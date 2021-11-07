<?php

namespace App\Contracts\Filters\FileFilters;

use App\Core\Abstracts\QueryFilter;
use App\Core\Interfaces\FilterInterface;

class Type extends QueryFilter implements FilterInterface
{
    public function handle($value): void
    {
        $this->query->whereIn("type", $value);
    }
}
