<?php

namespace App\Contracts\Filters\CommentFilters;

use App\Core\Abstracts\QueryFilter;
use App\Core\Interfaces\FilterContract;

class Fullname extends QueryFilter implements FilterContract
{
    public function handle($value): void
    {
        $this->query->where('fullname', "like", "%{$value}%")
            ->whereHas("user", function ($query) use ($value) {
                $query->where("users.name", "like", "%{$value}%");
            });
    }
}
