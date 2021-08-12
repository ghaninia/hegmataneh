<?php

namespace App\Providers;

use App\Models\User;
use App\Services\Access\AccessService;
use Laravel\Passport\Passport;
use Illuminate\Contracts\Auth\Access\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot(Gate $gate)
    {
        $this->registerPolicies();

        $gate->define("f_ability", function (User $user, ...$permissions) {
            return
                app(AccessService::class)
                ->setUser($user)
                ->setPermissions($permissions)
                ->fullAbility();
        });

        if (!$this->app->routesAreCached()) {
            Passport::routes();
        }
    }
}
