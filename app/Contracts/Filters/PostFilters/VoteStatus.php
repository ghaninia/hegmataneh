<?php

namespace App\Contracts\Filters\PostFilters;

use App\Core\Abstracts\QueryFilter;
use App\Core\Interfaces\FilterContract;

class VoteStatus extends QueryFilter implements FilterContract
{
    public function handle($value): void
    {
        $this->query->where('vote_status', $value);
    }
}
