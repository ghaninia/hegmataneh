<?php

use App\Core\Enums\EnumsOption;
use Illuminate\Support\Facades\Route;

Route::group([
    "as" => "guest.",
], function () {
    Route::view("/", "welcome")->name("main");
});


Route::get("test" , function(){
});

