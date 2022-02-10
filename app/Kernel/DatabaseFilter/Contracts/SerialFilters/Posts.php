<?php

namespace App\Kernel\DatabaseFilter\Contracts\SerialFilters;

use App\Kernel\DatabaseFilter\Abstracts\QueryFilter;
use App\Kernel\DatabaseFilter\Interfaces\FilterInterface;

class Posts extends QueryFilter implements FilterInterface
{
    public function handle($value): void
    {
        $value = is_integer($value) ? [$value] : $value ;
        $this->query->whereId('post_id' , $value );
    }
}
