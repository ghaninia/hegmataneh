<?php

namespace App\Kernel\DatabaseFilter\Contracts\SkillFilters;

use App\Kernel\Enums\EnumsSkill;
use App\Kernel\DatabaseFilter\Abstracts\QueryFilter;
use App\Kernel\DatabaseFilter\Interfaces\FilterInterface;

class Description extends QueryFilter implements FilterInterface
{
    public function handle($value): void
    {

        $this->query
            ->whereHas("translations", function ($query) use ($value) {
                $query->filterBy([
                    "field" => EnumsSkill::FIELD_DESCRIPTION,
                    "trans" => $value
                ]);
            });
    }
}
