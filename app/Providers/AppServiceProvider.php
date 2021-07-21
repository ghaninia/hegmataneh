<?php

namespace App\Providers;

use App\Core\Enums\EnumsTerm;
use App\Models\Post;
use App\Models\Term;
use App\Models\User;
use App\Models\Portfolio;
use App\Models\Quotation;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Relations\Relation;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

        foreach ([
            "tag" => Term::class,
            "category" => Term::class,
            "post" => Post::class,
            "product" => Post::class,
            "page" => Post::class
        ] as $name => $class) {
            Route::bind($name, function ($value) use ($name, $class) {
                return
                    $class::query()
                    ->when(
                        $name === EnumsTerm::TYPE_TAG,
                        fn ($query) => $query->tags()
                    )
                    ->when(
                        $name === EnumsTerm::TYPE_CATEGORY,
                        fn ($query) => $query->categories()
                    )
                    ->where(function ($query) use ($value) {
                        $query
                            ->where("slug", $value)
                            ->orWhere("id", $value);
                    })
                    ->firstOrFail();
            });
        }


        Relation::morphMap([
            "user" => User::class,
            "post" => Post::class,
            "portfolio" => Portfolio::class,
            "term" => Term::class,
            "quotation" => Quotation::class,
        ]);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
