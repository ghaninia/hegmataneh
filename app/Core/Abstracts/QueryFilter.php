<?php

namespace App\Core\Abstracts;

abstract class QueryFilter
{
    protected $query;

    public function __construct($query)
    {
        $this->query = $query;
    }
}
