<?php

namespace App\Kernel\DatabaseFilter\Contracts\TermFilters;

use App\Kernel\DatabaseFilter\Abstracts\QueryFilter;
use App\Kernel\Enums\EnumsTerm;
use App\Kernel\DatabaseFilter\Interfaces\FilterInterface;

class Description extends QueryFilter implements FilterInterface
{
    public function handle($value): void
    {

        $this->query
            ->whereHas("translations", function ($query) use ($value) {
                $query->filterBy([
                    "field" => EnumsTerm::FIELD_DESCRIPTION,
                    "trans" => $value
                ]);
            });
    }
}
