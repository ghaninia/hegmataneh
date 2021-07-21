<?php

use App\Core\Classes\Slugify;
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

/**
 * @param ?string  $text = null
 * @param ?string $alternateText = null
 * @return string
 */
function slug(?string $text = null , ?string $alternateText = null) : string
{
    return !! $text ? Slugify::create($text) : Slugify::create($alternateText) ;
}
