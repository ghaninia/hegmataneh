<?php

namespace App\Kernel\DatabaseFilter\Contracts\PostFilters;

use App\Kernel\DatabaseFilter\Abstracts\QueryFilter;
use App\Kernel\DatabaseFilter\Interfaces\FilterInterface;

class Format extends QueryFilter implements FilterInterface
{
    public function handle($value): void
    {
        $this->query->where('format', $value);
    }
}
