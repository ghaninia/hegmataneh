<?php

namespace App\Contracts\Filters\TranslationFilters;

use App\Core\Abstracts\QueryFilter;
use App\Core\Interfaces\FilterInterface;

class Trans extends QueryFilter implements FilterInterface
{
    public function handle($value): void
    {
        $this->query->whereRaw("MATCH(trans) AGAINST(?)", [$value]);
    }
}
