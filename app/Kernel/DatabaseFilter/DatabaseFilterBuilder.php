<?php

namespace App\Kernel\DatabaseFilter;

use Illuminate\Support\Str;
use App\Kernel\DatabaseFilter\Exceptions\NotFoundModelForFilter;

class DatabaseFilterBuilder
{
    protected $query;
    protected $filters;
    protected $namespace;
    protected $sensitiveNullValue;

    public function __construct(
        $query,
        array $filters,
        string $namespace,
        bool $sensitiveNullValue
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


            ########################
            ### در صورتی که بازده باشد آنگاه اعمال شود
            ########################

            $hasRangeFilters = false;

            if (
                is_array($value) &&
                count($range = $this->rangeFilter($value)) &&
                method_exists($class, "rangeHandle")
            ) {
                $value = $range;
                $hasRangeFilters = true;
            }


            if ($hasRangeFilters) {
                /**
                 * در صورتی که ورودی از نوع رنج باشد
                 * آنگاه باید رنج
                 */
                $value = array_filter($value, function ($item) {
                    $valueItem = $item[1] ?? null;
                    return !is_null($valueItem);
                });
            }

            ###########################
            ### حساسیت به نال داشته باشد
            ###########################

            ### در صورتی که حساس به مقدار نال نباشد
            if ($this->sensitiveNullValue === FALSE) {

                if (is_array($value)) {
                    /**
                     * در صورتی که ورودی از نوع آرایه باشد
                     */
                    $value = array_filter($value, function ($item) {
                        return !is_null($item);
                    });
                }

                if (
                    (is_array($value) && !count($value)) || ### در صورتی که مقدار آرایه ای خالی باشد :)
                    (!is_array($value) && is_null($value)) ### در صورتی که آرایه نباشد و مقدار خالی باشد
                ) {
                    ### از فیلتر این آیتم پرش کن
                    continue;
                }
            }

            ########################
            ### در صورتی که غیر بازده باشد اعمال شود
            ########################

            $filterInstance = new $class($this->query);

            $hasRangeFilters ? $filterInstance->rangeHandle($value) : $filterInstance->handle($value);
        }

        return $this->query;
    }


    /**
     * ساخت ارایه ایی از رنج های مختلف
     * @param array $keys
     * @return ?array
     */
    private function rangeFilter(array $keys): array
    {
        $filters = [];

        array_walk($keys, function ($value, $key) use (&$filters) {
            if ($operator = $this->operator($key)) {
                $filters[] = [
                    $operator, $value
                ];
            }
        });

        return $filters;
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
