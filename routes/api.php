<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Role\RoleController;
use App\Http\Controllers\Api\User\UserController;
use App\Http\Controllers\Api\Authunticate\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group([
    "prefix" => "authunticate",
    "as" => "authunticate.",
    "middleware" => [
        "throttle:10,1"
    ]
], function () {
    ### ورود به حساب کاربری
    Route::post("login", [AuthController::class, "login"])->name("login");
    ### ثبت نام در سیستم
    Route::group([
        "prefix" => "register",
        "as" => "register.",
    ], function () {
        Route::post("/", [AuthController::class, "register"])->name("store");
        Route::get("verify/{token}", [AuthController::class, "verify"])->name("verify");
    });
});

Route::group([
    "prefix" => "v1",
    "middleware" => [
        "auth:api"
    ]
], function () {
    ### role route
    Route::apiResource("role", RoleController::class);
    ### user route
    Route::apiResource("user", UserController::class);
    Route::group([
        "prefix" => "user",
        "as" => "user."
    ], function () {
        Route::get("{user}/views", [UserController::class, "views"])->name("views");
        Route::get("{user}/votes", [UserController::class, "votes"])->name("votes");
        Route::get("{user}/posts", [UserController::class, "posts"])->name("posts");
        Route::get("{user}/pages", [UserController::class, "pages"])->name("pages");
        Route::get("{user}/products", [UserController::class, "products"])->name("products");
        Route::get("{user}/skills", [UserController::class, "skills"])->name("skills");
        Route::get("{user}/portfolios", [UserController::class, "portfolios"])->name("portfolios");
        Route::get("{user}/comments", [UserController::class, "comments"])->name("comments");
    });
});
