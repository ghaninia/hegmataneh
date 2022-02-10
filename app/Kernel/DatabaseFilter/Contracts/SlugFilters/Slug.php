<?php

namespace App\Kernel\DatabaseFilter\Contracts\SlugFilters;

use App\Kernel\DatabaseFilter\Abstracts\QueryFilter;
use App\Kernel\DatabaseFilter\Interfaces\FilterInterface;

class Slug extends QueryFilter implements FilterInterface
{
    public function handle($value): void
    {
        $this->query->where('slug', $value);
    }
}
