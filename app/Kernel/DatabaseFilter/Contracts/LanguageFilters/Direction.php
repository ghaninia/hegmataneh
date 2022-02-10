<?php

namespace App\Kernel\DatabaseFilter\Contracts\LanguageFilters;

use App\Kernel\DatabaseFilter\Abstracts\QueryFilter;
use App\Kernel\DatabaseFilter\Interfaces\FilterInterface;

class Direction extends QueryFilter implements FilterInterface
{
    public function handle($value): void
    {
        $this->query->where('direction', $value);
    }
}
