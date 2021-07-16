<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(\App\Repositories\Role\RoleRepositoryInterface::class, \App\Repositories\Role\RoleRepository::class);
        $this->app->bind(\App\Repositories\User\UserRepositoryInterface::class, \App\Repositories\User\UserRepository::class);
        $this->app->bind(\App\Repositories\Option\OptionRepositoryInterface::class, \App\Repositories\Option\OptionRepository::class);
        $this->app->bind(\App\Repositories\View\ViewRepositoryInterface::class, \App\Repositories\View\ViewRepository::class);
        $this->app->bind(\App\Repositories\Vote\VoteRepositoryInterface::class, \App\Repositories\Vote\VoteRepository::class);
        //:end-bindings:
    }
}
