<?php

namespace App\Core\Classes;

use App\Exceptions\NotFoundModelForFilter;
use Illuminate\Support\Str;


class FilterBuilder
{
    public function __construct(
        protected $query,
        protected array $filters,
        protected string $namespace,
        protected bool $sensitiveNullValue
    ) {
        $this->query = $query;
        $this->filters = $filters;
        $this->namespace = $namespace;
        $this->sensitiveNullValue = $sensitiveNullValue;
    }

    public function apply()
    {
        foreach ($this->filters as $name => $value) {

            $normailizedName = ucwords(Str::camel($name));

            $class = sprintf("%s\\%s", $this->namespace, $normailizedName);


            if (!class_exists($class)) {
                throw new NotFoundModelForFilter($class);
            }

            ###########################
            ### حساسیت به نال نداشته باشد
            ###########################

            if (!$this->sensitiveNullValue) {
                if (is_array($value)) {
                    $value = array_filter($value, fn ($item) => !!$item);
                } elseif (
                    is_string($value) && is_null($value)
                ) {
                    continue;
                }
            }


            ########################
            ### در صورتی که بازده باشد آنگاه اعمال شود
            ########################

            if (is_array($value)) {
                if (
                    !!($range = $this->rangeFilter($value)) &&
                    method_exists($class, "rangeHandle")
                ) {

                    (new $class($this->query))->rangeHandle($range);

                    continue;
                }
            }


            ########################
            ### در صورتی که غیر بازده باشد اعمال شود
            ### پشتیبانی از false , null و غیره
            ########################

            $condition = is_bool($value) ? FALSE : empty($value) ;
            $condition ?: (new $class($this->query))->handle($value);
        }

        return $this->query;
    }


    /**
     * ساخت ارایه ایی از رنج های مختلف
     * @param array $keys
     * @return ?array
     */
    private function rangeFilter(array $keys): ?array
    {
        $filters = [];

        array_walk($keys, function ($value, $key) use (&$filters) {
            if ($operator = $this->operator($key)) {
                $filters[] = [
                    $operator, $value
                ];
            }
        });

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
