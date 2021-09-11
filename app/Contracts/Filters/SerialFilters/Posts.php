<?php

namespace App\Contracts\Filters\SerialFilters;

use App\Core\Abstracts\QueryFilter;
use App\Core\Interfaces\FilterInterface;

class Posts extends QueryFilter implements FilterInterface
{
    public function handle($value): void
    {
        $value = is_integer($value) ? [$value] : $value ;
        $this->query->whereId('post_id' , $value );
    }
}
