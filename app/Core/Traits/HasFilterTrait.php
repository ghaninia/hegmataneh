<?php

namespace App\Core\Traits;

use App\Core\Classes\FilterBuilder;

trait HasFilterTrait
{
    public function scopeFilterBy($query, $filters)
    {
        $namespace = $this->filterNamespace();
        $filter = new FilterBuilder($query, $filters, $namespace);
        return $filter->apply();
    }
}
