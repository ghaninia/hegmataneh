<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Term\TagController;
use App\Http\Controllers\Api\File\FileController;
use App\Http\Controllers\Api\Post\PageController;
use App\Http\Controllers\Api\Post\PostController;
use App\Http\Controllers\Api\Role\RoleController;
use App\Http\Controllers\Api\User\UserController;
use App\Http\Controllers\Api\Skill\SkillController;
use App\Http\Controllers\Api\Option\OptionController;
use App\Http\Controllers\Api\Term\CategoryController;
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
        "auth:api",
    ]
], function () {

    ##############
    ##############
    ##############
    ### role route
    ##############
    ##############
    Route::apiResource("role", RoleController::class);

    ##############
    ##############
    ### user route
    ##############
    ##############
    Route::apiResource("user", UserController::class);
    Route::group([
        "prefix" => "user/{user}",
        "as" => "user."
    ], function () {
        Route::get("views", [UserController::class, "views"])->name("views");
        Route::get("votes", [UserController::class, "votes"])->name("votes");
        Route::get("posts", [UserController::class, "posts"])->name("posts");
        Route::get("pages", [UserController::class, "pages"])->name("pages");
        Route::get("products", [UserController::class, "products"])->name("products");
        Route::get("skills", [UserController::class, "skills"])->name("skills");
        Route::get("portfolios", [UserController::class, "portfolios"])->name("portfolios");
        Route::get("comments", [UserController::class, "comments"])->name("comments");

        ########
        ### page
        ########
        Route::apiResource("page", PageController::class);
        Route::apiResource("post", PostController::class);
    });

    #######
    #######
    ### tag
    #######
    #######
    Route::apiResource("tag", TagController::class);

    ############
    ############
    ### category
    ############
    ############
    Route::apiResource("category", CategoryController::class);

    ###########
    ### options
    ###########
    Route::group([
        "prefix" => "option",
        "as" => "option.",
    ], function () {
        Route::get("/", [OptionController::class, "index"])->name("index");
        Route::patch("/", [OptionController::class, "update"])->name("update");
    });


    #########
    #########
    ### skill
    #########
    #########
    Route::apiResource("skill", SkillController::class);


    ########
    ### file
    ########
    Route::group([
        "as" => "file",
        "prefix" => "file"
    ], function () {
        Route::get("/", [FileController::class, "index"])->name("index");
        Route::post("/", [FileController::class, "store"])->name("store");
        Route::delete("/", [FileController::class, "destroy"])->name("destroy");
    });
});
