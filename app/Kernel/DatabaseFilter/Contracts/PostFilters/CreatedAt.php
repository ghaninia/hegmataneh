<?php

namespace App\Kernel\DatabaseFilter\Contracts\PostFilters;

use Carbon\Carbon;
use App\Kernel\DatabaseFilter\Abstracts\QueryFilter;
use App\Kernel\DatabaseFilter\Interfaces\FilterInterface;

class CreatedAt extends QueryFilter implements FilterInterface
{

    public function handle($value): void
    {
        $this->query->where("created_at", $value);
    }

    public function rangeHandle($values): void
    {
        foreach ($values as $value) {
            $this->query->where('created_at', $value[0], Carbon::parse($value[1]));
        }
    }
}
