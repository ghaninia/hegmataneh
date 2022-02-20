<?php

use App\Core\Enums\EnumsOption;
use Illuminate\Support\Facades\Route;

Route::group([
    "as" => "guest.",
], function () {
    Route::view("/", "welcome")->name("main");
});


Route::get("test" , function(){
    dd(
        // options()->put(EnumsOption::DASHBOARD_REGISTER_RULE , "1") ,
        options(EnumsOption::DASHBOARD_DEFAULT_REGISTER_ROLE)
    ) ;
});

