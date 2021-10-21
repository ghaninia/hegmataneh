<?php

namespace App\Providers;

use App\Models\Post;
use App\Models\User;
use App\Models\Serial;
use App\Models\Portfolio;
use App\Policies\PostPolicy;
use App\Policies\SerialPolicy;
use Laravel\Passport\Passport;
use App\Policies\PortfolioPolicy;
use App\Services\Access\AccessService;
use Illuminate\Contracts\Auth\Access\Gate;
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
    public function boot(Gate $gate)
    {
        $this->registerPolicies();

        ############
        ### GATE ###
        ############

        $gate->define("f_ability", function (User $user, ...$permissions) {
            return
                app(AccessService::class)
                ->setUser($user)
                ->setPermissions($permissions)
                ->fullAbility();
        });

        #######################
        ### Passport Routes ###
        #######################

        Passport::routes();
    }
}
