<?php

namespace Tests\Unit\Middlewares;

use Tests\TestCase;
use App\Models\Role;
use App\Models\User;
use App\Models\Permission;
use Illuminate\Http\Request;
use App\Http\Middleware\AccessMiddleware;
use Illuminate\Routing\Route as RoutingRoute;

class AccessTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_access_middleware()
    {
        // $routeAction = [
        //     "controller" => "App\\Api\\Controllers\\TestController@Test" ,
        //     "uses" => "App\\Api\\Controllers\\TestController"
        // ];
        // $user = User::factory()
        //     ->for(
        //         Role::factory()
        //             ->has(
        //                 Permission::factory()->state(["action" => $routeAction])
        //             )
        //     )
        //     ->create();

        // $request = new Request();

        // $request->setUserResolver(fn () => $user);

        // $route = (new RoutingRoute('GET', 'testing/test', ["uses" => $routeAction ] ))->bind($request) ;

        // $request->setRouteResolver(function () use ($request, $routeAction) {
        //     return
        // });

        // $middleware = new AccessMiddleware  ;
        // $response   = $middleware->handle($request , fn($response) => null ) ;

    }
}
