<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Role\RoleController;
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
    "as" => "authunticate"
], function () {
    Route::post("login", [AuthController::class, "login"])->name("login");
    Route::post("register", [AuthController::class, "register"])->name("register");
});

Route::group([
    "prefix" => "v1",
    "middleware" => [
        "auth:api"
    ]
], function () {
    Route::apiResource("role", RoleController::class);
});
