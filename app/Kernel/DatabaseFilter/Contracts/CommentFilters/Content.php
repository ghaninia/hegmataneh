<?php

namespace App\Kernel\DatabaseFilter\Contracts\CommentFilters;

use App\Kernel\DatabaseFilter\Abstracts\QueryFilter;
use App\Kernel\DatabaseFilter\Interfaces\FilterInterface;

class Content extends QueryFilter implements FilterInterface
{
    public function handle($value): void
    {
        $this->query->where('content', "like" , "%{$value}%");
    }
}
