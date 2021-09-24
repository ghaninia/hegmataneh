<?php

namespace App\Providers;

use App\Models\Post;
use App\Models\Term;
use App\Models\User;
use App\Models\Serial;
use App\Models\Episode;
use App\Models\Portfolio;
use App\Models\Quotation;
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
        Relation::morphMap([
            "user" => User::class,
            "post" => Post::class,
            "portfolio" => Portfolio::class,
            "term" => Term::class,
            "quotation" => Quotation::class,
            "serial" => Serial::class,
            "episode" => Episode::class,
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
