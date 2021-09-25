<?php

namespace App\Contracts\Filters\SerialFilters;

use App\Core\Enums\EnumsSerial;
use App\Core\Abstracts\QueryFilter;
use App\Core\Interfaces\FilterInterface;

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
