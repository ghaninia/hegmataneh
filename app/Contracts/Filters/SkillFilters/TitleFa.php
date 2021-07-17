<?php

namespace App\Contracts\Filters\SkillFilters;

use App\Core\Abstracts\QueryFilter;
use App\Core\Interfaces\FilterContract;

class TitleFa extends QueryFilter implements FilterContract
{
    public function handle($value): void
    {
        $this->query->where("title_fa" , "like" , "%{$value}%");
    }
}
