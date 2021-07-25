<?php

namespace App\Contracts\Filters\PortfolioFilters;

use App\Core\Abstracts\QueryFilter;
use App\Core\Interfaces\FilterInterface;
use Carbon\Carbon;

class LaunchedAt extends QueryFilter implements FilterInterface
{
    public function handle($value): void
    {
        $this->query->where("launched_at", $value);
    }

    public function rangeHandle($values): void
    {
        foreach ($values as $value) {
            $this->query->where('launched_at', $value[0] , Carbon::parse($value));
        }
    }
}
