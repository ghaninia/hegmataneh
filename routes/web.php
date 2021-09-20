<?php

use Illuminate\Support\Facades\Route;
use App\Http\Resources\Translation\TranslationCollection;

Route::group([
    "as" => "guest.",
], function () {
    Route::view("/", "welcome")->name("main");
});
