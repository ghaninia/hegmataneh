<?php

namespace App\Contracts\Filters\CommentFilters;

use App\Core\Abstracts\QueryFilter;
use App\Core\Interfaces\FilterInterface;

class Website extends QueryFilter implements FilterInterface
{
    public function handle($value): void
    {
        $this->query->where('website', $value);
    }
}
