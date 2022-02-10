<?php

namespace App\Kernel\DatabaseFilter\Contracts\FileFilters;

use App\Kernel\DatabaseFilter\Abstracts\QueryFilter;
use App\Kernel\DatabaseFilter\Interfaces\FilterInterface;

class Type extends QueryFilter implements FilterInterface
{
    public function handle($value): void
    {
        $this->query->whereIn("type", $value);
    }
}
