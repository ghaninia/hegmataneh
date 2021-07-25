<?php

namespace App\Contracts\Filters\VoteFilters;

use App\Core\Abstracts\QueryFilter;
use App\Core\Interfaces\FilterInterface;

class PostId extends QueryFilter implements FilterInterface
{
    public function handle($value): void
    {
        $this->query->where('post_id', $value);
    }
}
