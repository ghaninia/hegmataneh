<?php

namespace App\Kernel\DatabaseFilter\Contracts\UserFilters;

use App\Kernel\DatabaseFilter\Abstracts\QueryFilter;
use App\Kernel\DatabaseFilter\Interfaces\FilterInterface;

class JustTrashed extends QueryFilter implements FilterInterface
{
    public function handle($value): void
    {

        if($value){
            $this->query->whereNotNull('deleted_at');
        }else {
            $this->query->whereNull('deleted_at');
        }

    }
}
