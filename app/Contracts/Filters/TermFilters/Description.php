<?php

namespace App\Contracts\Filters\TermFilters;

use App\Core\Abstracts\QueryFilter;
use App\Core\Enums\EnumsTerm;
use App\Core\Interfaces\FilterInterface;

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
