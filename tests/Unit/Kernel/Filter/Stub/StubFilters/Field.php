<?php

namespace Tests\Unit\Kernel\Filter\Stub\StubFilters ;

use App\Kernel\DatabaseFilter\Abstracts\QueryFilter;
use App\Kernel\DatabaseFilter\Interfaces\FilterInterface;

class Field extends QueryFilter implements FilterInterface {


    public function handle($value): void
    {
        $this->query->where("field" , $value );
    }

}
