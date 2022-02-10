<?php

namespace App\Kernel\DatabaseFilter\Contracts\FileFilters;

use App\Kernel\DatabaseFilter\Abstracts\QueryFilter;
use App\Kernel\DatabaseFilter\Interfaces\FilterInterface;

class MimeType extends QueryFilter implements FilterInterface
{
    public function handle($value): void
    {
        $this->query->where("mime_type", $value);
    }
}
