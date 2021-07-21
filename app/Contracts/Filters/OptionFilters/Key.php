<?php

namespace App\Contracts\Filters\OptionFilters;

use App\Core\Abstracts\QueryFilter;
use App\Core\Interfaces\FilterContract;

class Key extends QueryFilter implements FilterContract
{
    public function handle($value): void
    {
        $this->query->where('key', $value);
    }
}
