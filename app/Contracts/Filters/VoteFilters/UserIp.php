<?php

namespace App\Contracts\Filters\VoteFilters;

use App\Core\Abstracts\QueryFilter;
use App\Core\Interfaces\FilterContract;

class UserIp extends QueryFilter implements FilterContract
{
    public function handle($value): void
    {
        $this->query->where('user_ip', $value);
    }
}
