<?php

namespace App\Kernel\DatabaseFilter\Contracts\PostFilters;

use App\Core\Enums\EnumsPost;
use App\Kernel\DatabaseFilter\Abstracts\QueryFilter;
use App\Kernel\DatabaseFilter\Interfaces\FilterInterface;

class Price extends QueryFilter implements FilterInterface
{
    public function handle($value): void
    {
        $this->query
            ->whereHas("prices", function ($query) use ($value) {
                $query->filterBy([
                    "price" => $value
                ]);
            });
    }
}
