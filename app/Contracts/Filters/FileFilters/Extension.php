<?php

namespace App\Contracts\Filters\FileFilters;

use App\Core\Abstracts\QueryFilter;
use App\Core\Interfaces\FilterInterface;

class Extension extends QueryFilter implements FilterInterface
{
    public function handle($value): void
    {
        $this->query->where("extension", $value);
    }
}
