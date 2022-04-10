<?php

namespace App\Kernel\DatabaseFilter\Contracts\PostFilters;

use App\Kernel\Enums\EnumsPost;
use App\Kernel\DatabaseFilter\Abstracts\QueryFilter;
use App\Kernel\DatabaseFilter\Interfaces\FilterInterface;

class Faq extends QueryFilter implements FilterInterface
{
    public function handle($value): void
    {
        $this->query
            ->whereHas("translations", function ($query) use ($value) {
                $query->filterBy([
                    "field" => EnumsPost::FIELD_FAQ ,
                    "trans" => $value
                ]);
            });
    }
}
