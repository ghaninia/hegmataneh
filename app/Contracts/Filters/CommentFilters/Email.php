<?php

namespace App\Contracts\Filters\CommentFilters;

use App\Core\Abstracts\QueryFilter;
use App\Core\Interfaces\FilterContract;

class Email extends QueryFilter implements FilterContract
{
    public function handle($value): void
    {
        $this->query->where('email', "like", "%{$value}%")
            ->whereHas("user", function ($query) use ($value) {
                $query->where("users.email", "like", "%{$value}%");
            });
    }
}
