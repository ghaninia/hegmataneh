<?php

namespace App\Contracts\Filters\SerialFilters;

use App\Core\Abstracts\QueryFilter;
use App\Core\Interfaces\FilterInterface;

class Title extends QueryFilter implements FilterInterface
{
    public function handle($value): void
    {
        $this->query->where('serials.title' , 'like', "%{$value}%");
    }
}
