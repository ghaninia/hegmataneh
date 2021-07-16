<?php

namespace App\Contracts\Filters\ViewFilters;

use App\Core\Abstracts\QueryFilter;
use App\Core\Interfaces\FilterContract;

class User extends QueryFilter implements FilterContract
{
    public function handle($value): void
    {
        $this->query->where('user_id', $value);
    }
}
