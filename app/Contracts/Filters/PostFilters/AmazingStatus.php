<?php

namespace App\Contracts\Filters\PostFilters;

use App\Core\Abstracts\QueryFilter;
use App\Core\Interfaces\FilterInterface;

class AmazingStatus extends QueryFilter implements FilterInterface
{
    public function handle($value): void
    {
        $this->query
            ->whereHas("prices", function ($query) use ($value) {
                $query->filterBy([
                    "Amazing_status" => $value
                ]);
            });
    }
}
