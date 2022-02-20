<?php

namespace Tests\Builders;

use App\Models\Option;

class OptionBuilder
{
    public static function set($key, $value): Option
    {
        return
            Option::updateOrCreate([
                "key" => $key
            ], [
                "value" => $value
            ]);
    }

    public static function get($key)
    {
        return Option::where("key", $key)->first();
    }
}
