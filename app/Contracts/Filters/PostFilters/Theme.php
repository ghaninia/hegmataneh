<?php

namespace App\Contracts\Filters\PostFilters;

use App\Core\Abstracts\QueryFilter;
use App\Core\Interfaces\FilterInterface;

class Theme extends QueryFilter implements FilterInterface
{
    public function handle($value): void
    {
        $this->query->where('theme', $value);
    }
}
