<?php

namespace App\Contracts\Filters\PostFilters;

use App\Core\Abstracts\QueryFilter;
use App\Core\Interfaces\FilterContract;

class Price extends QueryFilter implements FilterContract
{

    public function handle($value): void
    {
        $this->query->where("price" , $value) ;
    }

    public function rangeHandle($values) : void
    {
        foreach ($values as $value) {
            $this->query->where('price', ...$value);
        }
    }
}
