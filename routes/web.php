<?php

use App\Services\Widget\WidgetService;
use Illuminate\Support\Facades\Route;

Route::group([
    "as" => "guest.",
], function () {
    Route::view("/", "welcome")->name("main");
});

Route::get("test" , function(){

    $service = app(WidgetService::class) ;

    return $service->chartPosts() ;

});