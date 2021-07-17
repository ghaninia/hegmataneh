<?php

namespace App\Contracts\Filters\SkillFilters;

use App\Core\Abstracts\QueryFilter;
use App\Core\Interfaces\FilterContract;

class TitleEn extends QueryFilter implements FilterContract
{
    public function handle($value): void
    {
        $this->query->where("title_en" , "like" , "%{$value}%");
    }
}
