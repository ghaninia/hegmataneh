<?php

namespace App\Contracts\Filters\LanguageFilters;

use App\Core\Abstracts\QueryFilter;
use App\Core\Interfaces\FilterInterface;

class Direction extends QueryFilter implements FilterInterface
{
    public function handle($value): void
    {
        $this->query->where('direction', $value);
    }
}
