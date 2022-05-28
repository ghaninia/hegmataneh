<?php

use Illuminate\Support\Facades\Route;

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
        Route::post("login", [\App\Http\Controllers\Dashboard\Authunticate\AuthController::class, "login"])->name("login");
        ### ثبت نام در سیستم
        Route::group([
            "prefix" => "register",
            "as" => "register.",
        ], function () {
            Route::post("/", [\App\Http\Controllers\Dashboard\Authunticate\AuthController::class, "register"])->name("store");
            Route::get("verify/{token}", [\App\Http\Controllers\Dashboard\Authunticate\AuthController::class, "verify"])->name("verify");
        });
    });

    ##################
    ### GET ALL ROUTES
    ##################

    Route::get("routes", function () {
        return getRoutes()->map(fn ($route) => [
            "uri" => url($route["uri"]),
            "as" => $route["as"],
        ]);
    })->name("routes");


    Route::get("translations", \App\Http\Controllers\Guest\Translation\TranslationController::class)->name("translations");

    Route::middleware("auth:sanctum")->group(function () {


        ########
        ### file
        ########
        Route::prefix("filemanager/{user?}")->name("filemanager.")->group(function () {
            Route::get("/",  [\App\Http\Controllers\Dashboard\Filemanager\FilemanagerController::class, "index"])->name("index");
            Route::post("/",  [\App\Http\Controllers\Dashboard\Filemanager\FilemanagerController::class, "store"])->name("store");
        });

        ###########
        ### PROFILE
        ###########

        Route::prefix("profile")->name("profile.")->group(function () {
            Route::get("/", [\App\Http\Controllers\Dashboard\Profile\ProfileController::class, "index"])->name("index");
            Route::post("/", [\App\Http\Controllers\Dashboard\Profile\ProfileController::class, "store"])->name("store");
        });

        ##############
        ### role route
        ##############
        Route::apiResource("role", \App\Http\Controllers\Dashboard\Role\RoleController::class);

        ##############
        ### gatway route
        ##############
        Route::apiResource("gateway", \App\Http\Controllers\Dashboard\Gateway\GatewayController::class);

        ##############
        ### language route
        ##############
        Route::apiResource("language", \App\Http\Controllers\Dashboard\Language\LanguageController::class);

        ##############
        ### currency route
        ##############
        Route::apiResource("currency", \App\Http\Controllers\Dashboard\Currency\CurrencyController::class);

        ##############
        ### user route
        ##############
        Route::apiResource("user", \App\Http\Controllers\Dashboard\User\UserController::class);
        Route::prefix("user/{user}")->name("user.")->group(function () {

            ###########
            ### restore
            ###########
            Route::post("restore", [\App\Http\Controllers\Dashboard\User\UserController::class, "restore"])->name("restore");

            ############
            ### portfolio
            ############
            Route::apiResource("portfolio", \App\Http\Controllers\Dashboard\Portfolio\PortfolioController::class);

            ########
            ### page
            ########
            Route::apiResource("page", \App\Http\Controllers\Dashboard\Post\PageController::class);

            ########
            ### post
            ########
            Route::apiResource("post", \App\Http\Controllers\Dashboard\Post\PostController::class);
            Route::group([
                "prefix" => "post/{post}",
                "as" => "post."
            ], function () {
                Route::delete("force", [\App\Http\Controllers\Dashboard\Post\PostController::class, "forceDelete"])->name("force");
                Route::post("restore", [\App\Http\Controllers\Dashboard\Post\PostController::class, "restore"])->name("restore");
            });

            ##########
            ### serial
            ##########
            Route::apiResource("serial", \App\Http\Controllers\Dashboard\Serial\SerialController::class);

            ###########
            ### product
            ###########
            Route::apiResource("product", \App\Http\Controllers\Dashboard\Post\ProductController::class);
            Route::group([
                "prefix" => "product/{product}",
                "as" => "product."
            ], function () {
                Route::delete("force", [\App\Http\Controllers\Dashboard\Post\ProductController::class, "forceDelete"])->name("force");
                Route::post("restore", [\App\Http\Controllers\Dashboard\Post\ProductController::class, "restore"])->name("restore");
            });

        });

        #######
        ### tag
        #######
        Route::apiResource("tag", \App\Http\Controllers\Dashboard\Term\TagController::class);

        ############
        ### category
        ############
        Route::apiResource("category", \App\Http\Controllers\Dashboard\Term\CategoryController::class);

        ###########
        ### options
        ###########

        Route::group([
            "prefix" => "option",
            "as" => "option.",
        ], function () {
            Route::get("/", [\App\Http\Controllers\Dashboard\Option\OptionController::class, "index"])->name("index");
            Route::patch("/", [\App\Http\Controllers\Dashboard\Option\OptionController::class, "update"])->name("update");
        });

        #########
        ### skill
        #########
        Route::apiResource("skill", \App\Http\Controllers\Dashboard\Skill\SkillController::class);

        Route::prefix("widget")->name("widget.")->group(function () {
            Route::name("statistic.")->prefix("statistic")->group(function () {
                Route::get("posts", [\App\Http\Controllers\Dashboard\Widget\WidgetController::class, "statisticPosts"])->name("posts");
                Route::get("users", [\App\Http\Controllers\Dashboard\Widget\WidgetController::class, "statisticUsers"])->name("users");
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
            Route::get("product/{product}", [\App\Http\Controllers\Dashboard\Basket\BasketController::class, "append"])->name("product");
            Route::get("serial/{serial}", [\App\Http\Controllers\Dashboard\Basket\BasketController::class, "append"])->name("serial");
        });
    });
});
