<?php

namespace App\Core\Interfaces;

interface FilterableInterface
{
    public function scopeFilterBy($query, $filters);

    public function filterNamespace() : string ;

}
