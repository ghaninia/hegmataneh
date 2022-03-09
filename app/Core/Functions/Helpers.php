<?php

use App\Core\Classes\Slugify;
use Illuminate\Support\Facades\Route;
use App\Services\Option\OptionService;

/**
 * تنظیمات
 * @param ?string $key
 * @param $default
 */
function options(?string $key = null)
{
    $instance =  OptionService::getInstance();
    return !!$key ? $instance->get($key) : $instance;
}

/**
 * ساخت اسلاگ
 * @param $text
 * @return string
 */
function slug(string $text): string
{
    return Slugify::create($text);
}

/**
 * دریافت تمام اکشن مسیرها
 */
function getRoutes()
{
    $routes = [];
    collect(Route::getRoutes())
        ->map(function ($route) use (&$routes) {
        $method = $route->action['uses'];
            if (
                is_string($method) &&
                str_starts_with($method, "App\Http\Controllers")
            )
                $routes[] = [
                        "uri" => $route->uri() ,
                        "as"  => $route->action["as"] ,
                        "method" => md5( $method ),
                ];
        });

    return collect($routes);
}

/**
 * لوگوهای وب سایت
 * @return string
 */
function logo()
{
    ### ازدیتابیس باید خوانده شود
    return "";
}
