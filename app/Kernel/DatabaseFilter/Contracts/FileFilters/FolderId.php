<?php

namespace App\Kernel\DatabaseFilter\Contracts\FileFilters;

use App\Kernel\DatabaseFilter\Abstracts\QueryFilter;
use App\Kernel\DatabaseFilter\Interfaces\FilterInterface;

class FolderId extends QueryFilter implements FilterInterface
{
    public function handle($value): void
    {
        $this->query->whereHas("folder_id" , $value);
    }
}
