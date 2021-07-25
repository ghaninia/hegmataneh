<?php

namespace App\Contracts\Filters\UserFilters;

use App\Core\Abstracts\QueryFilter;
use App\Core\Interfaces\FilterInterface;

class Email extends QueryFilter implements FilterInterface
{
    public function handle($value): void
    {
        $this->query->where('email', $value);
    }
}
