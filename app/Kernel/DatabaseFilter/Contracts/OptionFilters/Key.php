<?php

namespace App\Kernel\DatabaseFilter\Contracts\OptionFilters;

use App\Kernel\DatabaseFilter\Abstracts\QueryFilter;
use App\Kernel\DatabaseFilter\Interfaces\FilterInterface;

class Key extends QueryFilter implements FilterInterface
{
    public function handle($value): void
    {
        $this->query->where('key', $value);
    }
}
