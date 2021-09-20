<?php

namespace App\Providers;

use App\Models\Post;
use App\Models\Serial;
use App\Models\Term;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * This is used by Laravel authentication to redirect users after login.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * The controller namespace for the application.
     *
     * When present, controller route declarations will automatically be prefixed with this namespace.
     *
     * @var string|null
     */
    // protected $namespace = 'App\\Http\\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {

        $this->configureRateLimiting();

        /**
         * در سیستم طوری که slugable را تنظیم مینماییم که فقط فقط از رکورد های مدنظر دریافت نماید
         * به این منظور ما باید کلاس و نوع scopeRelationMethod را به سیستم دهیم
         */
        foreach ([
            "serial" => [
                "class" => Serial::class,
            ],
            "tag" => [
                "class" => Term::class,
                "relationMethod" => "tags"
            ],
            "category" => [
                "class" => Term::class,
                "relationMethod" => "categories"
            ],
            "page" => [
                "class" => Post::class,
                "relationMethod" => "pages"
            ],
            "post" => [
                "class" => Post::class,
                "relationMethod" => "posts"
            ],
            "product" => [
                "class" => Post::class,
                "relationMethod" => "products"
            ],
        ] as $name => $detail) {
            Route::bind($name, function ($value) use ($detail) {
                $class = $detail["class"];
                $relationMethod = $detail["relationMethod"] ?? null;
                $hasTrashed = method_exists(new $class, "trashed") ;
                return
                    $class::query()
                    ->when(
                        !! $relationMethod,
                        fn ($query) => $query->{$relationMethod}()
                    )
                    ->where(function ($query) use ($value) {
                        $query
                            ->where("slug", $value)
                            ->orWhere("id", $value);
                    })
                    ->when($hasTrashed , function($query){
                        $query->withTrashed() ;
                    })
                    ->firstOrFail();
            });
        }

        $this->routes(function () {
            Route::prefix('api')
                ->middleware('api')
                ->namespace($this->namespace)
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->namespace($this->namespace)
                ->group(base_path('routes/web.php'));
        });
    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting()
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by(optional($request->user())->id ?: $request->ip());
        });
    }
}
