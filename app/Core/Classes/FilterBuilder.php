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
            $normailizedName = Str::ucfirst($normailizedName);
            $class = $this->namespace . "\\{$normailizedName}";

            if (!class_exists($class)) {
                continue;
            }

            ########################
            ### range method handler
            ########################

            if (
                is_array($value) &&
                method_exists($class, "rangeHandle") &&
                !! $range = $this->rangeSupport($value)
            ) {
                (new $class($this->query))->rangeHandle($range);
                continue;
            }

            #######################
            ### default method
            #######################
            (new $class($this->query))->handle($value);

        }
        return $this->query;
    }


    /**
     * ساخت ارایه ایی از رنج های مختلف
     * @param array $keys
     * @return ?array
     */
    private function rangeSupport(array $keys): ?array
    {
        $filters = [];

        foreach ($keys as $key => $value) {
            if (!!$operator = $this->operator($key)) {
                $filters[] = [
                    $operator, $value
                ];
            }
        }

        return count($filters) ? $filters : null;
    }

    /**
     * در صورتی که ولیدیشن بر اساس رنج باشد
     * @param $key
     * @return ?string
     */
    public function operator($key): ?string
    {
        $key = trim(strtolower($key));
        switch ($key) {
                ## کوچکتر مساوی
            case "lte":
                return "<=";
                ## بزرگتر مساوی
            case "gte":
                return ">=";
                ## کوچکتر
            case "lt":
                return "<";
                ## بزرگتر
            case "gt":
                return ">";
        }

        return null;
    }
}
