<?php

namespace App\Kernel\DatabaseFilter\Contracts\SerialFilters;

use App\Kernel\Enums\EnumsSerial;
use App\Kernel\DatabaseFilter\Abstracts\QueryFilter;
use App\Kernel\DatabaseFilter\Interfaces\FilterInterface;

class Title extends QueryFilter implements FilterInterface
{
    public function handle($value): void
    {
        $this->query
            ->whereHas("translations", function ($query) use ($value) {
                $query->filterBy([
                    "field" => EnumsSerial::FIELD_TITLE,
                    "trans" => $value
                ]);
            });
    }
}
