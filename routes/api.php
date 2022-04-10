<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\Term\TagController;
use App\Http\Controllers\Dashboard\Post\PageController;
use App\Http\Controllers\Dashboard\Post\PostController;
use App\Http\Controllers\Dashboard\Role\RoleController;
use App\Http\Controllers\Dashboard\User\UserController;
use App\Http\Controllers\Dashboard\Skill\SkillController;
use App\Http\Controllers\Dashboard\Post\ProductController;
use App\Http\Controllers\Dashboard\Basket\BasketController;
use App\Http\Controllers\Dashboard\Option\OptionController;
use App\Http\Controllers\Dashboard\Serial\SerialController;
use App\Http\Controllers\Dashboard\Term\CategoryController;
use App\Http\Controllers\Dashboard\Gateway\GatewayController;
use App\Http\Controllers\Dashboard\Authunticate\AuthController;
use App\Http\Controllers\Dashboard\Currency\CurrencyController;
use App\Http\Controllers\Dashboard\Language\LanguageController;
use App\Http\Controllers\Dashboard\Portfolio\PortfolioController;
use App\Http\Controllers\Dashboard\Widget\WidgetController;
use App\Http\Controllers\Guest\Translation\TranslationController;


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
    "prefix" => "v1",
    "as" => "api.v1.",
], function () {

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

    ##################
    ### GET ALL ROUTES
    ##################

    Route::get("routes", function (){
        return getRoutes()->map(fn ($route) => [
            "uri" => url($route["uri"]),
            "as" => $route["as"],
        ]);
    })->name("routes");


    Route::get("translations", TranslationController::class)->name("translations");

    Route::middleware("auth:sanctum")->group(function () {

        Route::prefix("profile")->name("profile.")->group(function(){
            Route::get("/" , [\App\Http\Controllers\Dashboard\Profile\ProfileController::class , "index"] )->name("index");
            Route::post("/" , [\App\Http\Controllers\Dashboard\Profile\ProfileController::class , "store"] )->name("store");
        });

        ##############
        ### role route
        ##############
        Route::apiResource("role", RoleController::class);

        ##############
        ### gatway route
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

            ########
            ### file
            ########
            // Route::prefix("gallery")->name("gallery.")->group(function () {
            //     Route::post("newfolder/{folder?}", [FileController::class, "newFolder"])->name("new_folder");
            //     Route::post("upload/{folder?}", [FileController::class, "upload"])->name("upload");
            //     Route::put("move/{file}/{folder?}", [FileController::class, "move"])->name("move");
            //     Route::put("rename/{file}", [FileController::class, "rename"])->name("rename");
            //     Route::delete("{file}", [FileController::class, "remove"])->name("remove");
            //     Route::get("{folder?}", [FileController::class, "index"])->name("index");
            // });
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

        Route::prefix("widget")->name("widget.")->group(function () {
            Route::name("statistic.")->prefix("statistic")->group(function () {
                Route::get("posts", [WidgetController::class, "statisticPosts"])->name("posts");
            });
        });
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
