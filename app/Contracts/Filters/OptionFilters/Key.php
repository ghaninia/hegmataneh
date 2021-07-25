<?php

namespace App\Contracts\Filters\OptionFilters;

use App\Core\Abstracts\QueryFilter;
use App\Core\Interfaces\FilterInterface;

class Key extends QueryFilter implements FilterInterface
{
    public function handle($value): void
    {
        $this->query->where('key', $value);
    }
}
