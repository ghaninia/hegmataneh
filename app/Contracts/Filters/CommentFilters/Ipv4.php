<?php

namespace App\Contracts\Filters\CommentFilters;

use App\Core\Abstracts\QueryFilter;
use App\Core\Interfaces\FilterContract;

class Ipv4 extends QueryFilter implements FilterContract
{
    public function handle($value): void
    {
        $this->query->where('ipv4', $value);
    }
}
