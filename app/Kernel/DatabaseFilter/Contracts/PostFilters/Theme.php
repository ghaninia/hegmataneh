<?php

namespace App\Kernel\DatabaseFilter\Contracts\PostFilters;

use App\Kernel\DatabaseFilter\Abstracts\QueryFilter;
use App\Kernel\DatabaseFilter\Interfaces\FilterInterface;

class Theme extends QueryFilter implements FilterInterface
{
    public function handle($value): void
    {
        $this->query->where('theme', $value);
    }
}
