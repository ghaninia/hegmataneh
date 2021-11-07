<?php

namespace App\Contracts\Filters\FileFilters;

use App\Core\Abstracts\QueryFilter;
use App\Core\Interfaces\FilterInterface;

class MimeType extends QueryFilter implements FilterInterface
{
    public function handle($value): void
    {
        $this->query->where("mime_type", $value);
    }
}
