<?php

namespace App\Services\Option;

use App\Models\Option;
use App\Services\Option\OptionServiceInterface;

class OptionService implements OptionServiceInterface
{

    protected static $instances;

    private function __construct(){}

    /**
     * singleton instance
     * @return static
     */
    public static function getInstance(): self
    {
        $cls = new self();
        if (is_null(self::$instances)) {
            self::$instances = $cls->getRecordesInDatabase();
        }
        return $cls;
    }

    /**
     * Get information from the database
     * @return array
     */
    public function getRecordesInDatabase(): array
    {
        return
            Option::all([
                "key", "value", "default"
            ])->toArray();
    }


    /**
     * get field in cache or database
     * @param string $key
     * @return mixed|null
     */
    public function get(string $key)
    {
        $data = collect(self::$instances)->where("key", $key)->first();

        return !! $data ? ($data["value"] ?? $data["default"]) : null ;
    }

    /**
     * update option field
     * @param string $key
     * @param $value
     * @return Option
     */
    public function put(string $key,  $value): Option
    {
        $config = Option::updateOrCreate(["key" => $key], ["value" => $value]);
        return $config;
    }
}
