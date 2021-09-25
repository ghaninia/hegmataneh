<?php

namespace App\Contracts\Filters\SkillFilters;

use App\Core\Enums\EnumsSkill;
use App\Core\Abstracts\QueryFilter;
use App\Core\Interfaces\FilterInterface;

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
