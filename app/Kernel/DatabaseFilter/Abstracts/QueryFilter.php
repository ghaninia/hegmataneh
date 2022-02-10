<?php

namespace App\Kernel\DatabaseFilter\Abstracts;

abstract class QueryFilter
{
    protected $query;

    public function __construct($query)
    {
        $this->query = $query;
    }
}
