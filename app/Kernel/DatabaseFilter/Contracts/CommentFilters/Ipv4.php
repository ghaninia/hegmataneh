<?php

namespace App\Kernel\DatabaseFilter\Contracts\CommentFilters;

use App\Kernel\DatabaseFilter\Abstracts\QueryFilter;
use App\Kernel\DatabaseFilter\Interfaces\FilterInterface;

class Ipv4 extends QueryFilter implements FilterInterface
{
    public function handle($value): void
    {
        $this->query->where('ipv4', $value);
    }
}
