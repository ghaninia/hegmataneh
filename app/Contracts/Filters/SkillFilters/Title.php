<?php

namespace App\Contracts\Filters\SkillFilters;

use App\Core\Abstracts\QueryFilter;
use App\Core\Interfaces\FilterInterface;

class Title extends QueryFilter implements FilterInterface
{
    public function handle($value): void
    {
        $this->query->where("title" , "like" , "%{$value}%");
    }
}
