<?php

namespace App\Kernel\DatabaseFilter\Contracts\FileFilters;

use App\Kernel\DatabaseFilter\Abstracts\QueryFilter;
use App\Kernel\DatabaseFilter\Interfaces\FilterInterface;

class UserId extends QueryFilter implements FilterInterface
{
    public function handle($value): void
    {
        $this->query->where("user_id", $value);
    }
}
