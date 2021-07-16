<?php

namespace App\Contracts\Filters\VoteFilters;

use App\Core\Abstracts\QueryFilter;
use App\Core\Interfaces\FilterContract;

class PostId extends QueryFilter implements FilterContract
{
    public function handle($value): void
    {
        $this->query->where('post_id', $value);
    }
}
