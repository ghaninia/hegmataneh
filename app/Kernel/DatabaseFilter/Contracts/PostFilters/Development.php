<?php

namespace App\Kernel\DatabaseFilter\Contracts\PostFilters;

use App\Kernel\DatabaseFilter\Abstracts\QueryFilter;
use App\Kernel\DatabaseFilter\Interfaces\FilterInterface;

class Development extends QueryFilter implements FilterInterface
{
    public function handle($value): void
    {
        $this->query->where("development", $value);
    }

    public function rangeHandle($values): void
    {
        foreach ($values as $value) {
            $this->query->where('development', ...$value);
        }
    }
}
