<?php

namespace App\Services\Option;

use App\Models\Option;
use App\Services\Option\OptionServiceInterface;

class OptionService implements OptionServiceInterface
{
    protected static $instances;

    private function __construct()
    {
    }

    public static function getInstance(): self
    {
        $cls = new self();
        if (is_null(self::$instances)) {
            self::$instances = $cls->getRecordesInDatabase();
        }
        return $cls;
    }

    /**
     * دریافت اطلاعات از دیتابیس
     * @return mixed
     */
    public function getRecordesInDatabase(): array
    {

        return
            Option::all([
                "key", "value", "default"
            ])->toArray();
    }


    /**
     * @param string $key
     * @param $default
     * @return array|string
     */
    public function get(string $key, $default = null)
    {
        $data = collect(self::$instances)->where("key", $key)->first();

        $value = isset($data["value"]) ? unserialize($data["value"]) : null;

        $defaultData = isset($data["default"]) ? $data["default"] : null;

        $result = $value ?? $default ?? $defaultData ?? null;

        return $result;
    }

    /**
     * @param string $key
     * @param mixed $value
     * @return Option
     */
    public function put(string $key,  $value): Option
    {
        $config = Option::updateOrCreate(["key" => $key], ["value" => serialize($value)]);
        return $config;
    }
}
