<?php

namespace App\Core\Classes;

use Illuminate\Support\Str;

class FilterBuilder
{
    protected $query;
    protected $filters;
    protected $namespace;

    public function __construct($query, array $filters, string $namespace)
    {
        $this->query = $query;
        $this->filters = $filters;
        $this->namespace = $namespace;
    }

    public function apply()
    {
        foreach ($this->filters as $name => $value) {
            $normailizedName = Str::camel($name);
            $normailizedName = Str::ucfirst($normailizedName) ;
            $class = $this->namespace . "\\{$normailizedName}";

            if (!class_exists($class)) {
                continue;
            }

            (new $class($this->query))->handle($value);
        }
        return $this->query;
    }
}
