<?php

namespace App\Kernel\DatabaseFilter\Contracts\TranslationFilters;

use App\Kernel\DatabaseFilter\Abstracts\QueryFilter;
use App\Kernel\DatabaseFilter\Interfaces\FilterInterface;

class Trans extends QueryFilter implements FilterInterface
{
    public function handle($value): void
    {
        $this->query->where("trans", $value);
    }
}
