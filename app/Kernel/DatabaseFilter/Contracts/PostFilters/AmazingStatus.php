<?php

namespace App\Kernel\DatabaseFilter\Contracts\PostFilters;

use App\Kernel\DatabaseFilter\Abstracts\QueryFilter;
use App\Kernel\DatabaseFilter\Interfaces\FilterInterface;

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
