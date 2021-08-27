<?php

use App\Models\Role;
use App\Models\User;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\AccessMiddleware;

Route::group([
    "as" => "guest.",
], function () {
    Route::get("/" , function(){

 
    });
    // Route::view("/", "welcome")->name("main");
});
