<?php

namespace App\Kernel\DatabaseFilter\Contracts\VoteFilters;

use App\Kernel\DatabaseFilter\Abstracts\QueryFilter;
use App\Kernel\DatabaseFilter\Interfaces\FilterInterface;

class PostId extends QueryFilter implements FilterInterface
{
    public function handle($value): void
    {
        $this->query->where('post_id', $value);
    }
}
