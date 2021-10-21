<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Term\TagController;
use App\Http\Controllers\Api\File\FileController;
use App\Http\Controllers\Api\Post\PageController;
use App\Http\Controllers\Api\Post\PostController;
use App\Http\Controllers\Api\Role\RoleController;
use App\Http\Controllers\Api\User\UserController;
use App\Http\Controllers\Api\Skill\SkillController;
use App\Http\Controllers\Api\Post\ProductController;
use App\Http\Controllers\Api\Basket\BasketController;
use App\Http\Controllers\Api\Option\OptionController;
use App\Http\Controllers\Api\Serial\SerialController;
use App\Http\Controllers\Api\Term\CategoryController;
use App\Http\Controllers\Api\Gateway\GatewayController;
use App\Http\Controllers\Api\Authunticate\AuthController;
use App\Http\Controllers\Api\Currency\CurrencyController;
use App\Http\Controllers\Api\Language\LanguageController;
use App\Http\Controllers\Api\Portfolio\PortfolioController;

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
    ### role route
    ##############
    Route::apiResource("role", RoleController::class);



    ##############
    ### role route
    ##############
    Route::apiResource("gateway", GatewayController::class);


    ##############
    ### language route
    ##############
    Route::apiResource("language", LanguageController::class);

    ##############
    ### currency route
    ##############
    Route::apiResource("currency", CurrencyController::class);

    ##############
    ### user route
    ##############
    Route::apiResource("user", UserController::class);
    Route::group([
        "prefix" => "user/{user}",
        "as" => "user."
    ], function () {

        ############
        ### portfolio
        ############
        Route::apiResource("portfolio", PortfolioController::class);


        ########
        ### page
        ########
        Route::apiResource("page", PageController::class);

        ########
        ### post
        ########
        Route::apiResource("post", PostController::class);
        Route::group([
            "prefix" => "post/{post}",
            "as" => "post."
        ], function () {
            Route::delete("force", [PostController::class, "forceDelete"])->name("force");
            Route::post("restore", [PostController::class, "restore"])->name("restore");
        });

        ##########
        ### serial
        ##########
        Route::apiResource("serial", SerialController::class);

        ###########
        ### product
        ###########
        Route::apiResource("product", ProductController::class);
        Route::group([
            "prefix" => "product/{product}",
            "as" => "product."
        ], function () {
            Route::delete("force", [ProductController::class, "forceDelete"])->name("force");
            Route::post("restore", [ProductController::class, "restore"])->name("restore");
        });
    });

    #######
    ### tag
    #######
    Route::apiResource("tag", TagController::class);

    ############
    ### category
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
    ### skill
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


Route::name("guest.")->group(function () {
    Route::group([
        "as" => "basket.",
        "prefix" => "basket"
    ], function () {

        Route::group([
            "prefix" => "append",
            "as" => "append."
        ], function () {
            Route::get("product/{product}", [BasketController::class, "append"])->name("product");
            Route::get("serial/{serial}", [BasketController::class, "append"])->name("serial");
        });
    });
});
