<?php

namespace Tests\Unit\Middlewares;

use Tests\TestCase;
use App\Models\Role;
use App\Models\User;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
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

        $routeAction = "TestController@Test";

        $user = User::factory()
            ->for(
                Role::factory()
                    ->has(
                        Permission::factory()->state(["action" => $routeAction])
                    )
            )
            ->create();

        $request = new Request();

        $request->setRouteResolver(function () use ($request , $routeAction) {
            $route = Route::get("test" , $routeAction)->name("test") ;
            return $route->bind($request);
        });

        $request->setUserResolver(fn () => $user);

        $middleware = new AccessMiddleware  ;
        $response   = $middleware->handle($request ,function($next){}) ;
        
        $this->assertNull( $response ) ;
    }
}
