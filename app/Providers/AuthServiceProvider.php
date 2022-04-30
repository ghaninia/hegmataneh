<?php

namespace App\Providers;

use App\Models\Post;
use App\Models\User;
use App\Models\Serial;
use App\Models\Portfolio;
use App\Policies\PostPolicy;
use App\Policies\SerialPolicy;
use App\Policies\PortfolioPolicy;
use Illuminate\Support\Facades\Gate;
use App\Services\Access\AccessService;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Post::class => PostPolicy::class,
        Portfolio::class => PortfolioPolicy::class,
        Serial::class => SerialPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        ############
        ### GATE ###
        ############

        Gate::define("f_ability", function (User $user, ...$permissions) {
            return
                app(AccessService::class)
                ->setUser($user)
                ->setPermissions($permissions)
                ->fullAbility();
        });
    }
}
