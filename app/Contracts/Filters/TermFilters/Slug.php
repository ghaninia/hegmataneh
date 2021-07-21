<?php

namespace App\Contracts\Filters\TermFilters;

use App\Core\Abstracts\QueryFilter;
use App\Core\Interfaces\FilterContract;

class Slug extends QueryFilter implements FilterContract
{
    public function handle($value): void
    {
        $this->query->where('slug', $value);
    }
}
