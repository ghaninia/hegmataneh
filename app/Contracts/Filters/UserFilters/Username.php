<?php

namespace App\Contracts\Filters\UserFilters;

use App\Core\Abstracts\QueryFilter;
use App\Core\Interfaces\FilterContract;

class Username extends QueryFilter implements FilterContract
{
    public function handle($value): void
    {
        $this->query->where('username', $value);
    }
}
