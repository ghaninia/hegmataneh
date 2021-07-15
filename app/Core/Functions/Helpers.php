<?php

use App\Services\Option\OptionService;

/**
 * @param ?string $key
 * @param $default
 */
function options(?string $key = null, $default = null)
{
    $instance =  OptionService::getInstance();
    return !!$key ? $instance->get($key, $default) : $instance;
}
