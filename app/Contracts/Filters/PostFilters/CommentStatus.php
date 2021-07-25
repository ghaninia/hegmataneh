<?php

namespace App\Contracts\Filters\PostFilters;

use App\Core\Abstracts\QueryFilter;
use App\Core\Interfaces\FilterInterface;

class CommentStatus extends QueryFilter implements FilterInterface
{
    public function handle($value): void
    {
        $this->query->where('comment_status', $value);
    }
}
