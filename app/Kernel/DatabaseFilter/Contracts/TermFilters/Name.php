<?php

namespace App\Kernel\DatabaseFilter\Contracts\TermFilters;

use App\Kernel\DatabaseFilter\Abstracts\QueryFilter;
use App\Core\Enums\EnumsTerm;
use App\Kernel\DatabaseFilter\Interfaces\FilterInterface;

class Name extends QueryFilter implements FilterInterface
{
    public function handle($value): void
    {
        $this->query
            ->whereHas("translations", function ($query) use ($value) {
                $query->filterBy([
                    "field" => EnumsTerm::FIELD_NAME,
                    "trans" => $value
                ]);
            });
    }
}
