<?php

namespace App\Contracts\Filters\UserFilters;

use App\Core\Abstracts\QueryFilter;
use App\Core\Interfaces\FilterContract;

class Status extends QueryFilter implements FilterContract
{
    public function handle($value): void
    {
        $this->query->where('status', $value);
    }
}
