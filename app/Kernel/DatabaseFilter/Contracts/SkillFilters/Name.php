<?php

namespace App\Kernel\DatabaseFilter\Contracts\SkillFilters;

use App\Core\Enums\EnumsSkill;
use App\Kernel\DatabaseFilter\Abstracts\QueryFilter;
use App\Kernel\DatabaseFilter\Interfaces\FilterInterface;

class Name extends QueryFilter implements FilterInterface
{
    public function handle($value): void
    {
        $this->query
            ->whereHas("translations", function ($query) use ($value) {
                $query->filterBy([
                    "field" => EnumsSkill::FIELD_NAME,
                    "trans" => $value
                ]);
            });
    }
}
