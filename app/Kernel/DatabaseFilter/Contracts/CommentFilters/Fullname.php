<?php

namespace App\Kernel\DatabaseFilter\Contracts\CommentFilters;

use App\Kernel\DatabaseFilter\Abstracts\QueryFilter;
use App\Kernel\DatabaseFilter\Interfaces\FilterInterface;

class Fullname extends QueryFilter implements FilterInterface
{
    public function handle($value): void
    {
        $this->query->where('fullname', "like", "%{$value}%")
            ->whereHas("user", function ($query) use ($value) {
                $query->where("users.name", "like", "%{$value}%");
            });
    }
}
