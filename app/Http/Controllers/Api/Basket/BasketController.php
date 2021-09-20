<?php

namespace App\Http\Controllers\Api\Basket;

use App\Http\Resources\Basket\BasketResource;
use App\Core\Interfaces\BasktableInterface;
use App\Http\Requests\Basket\BasketStore;
use App\Services\Authunticate\AuthService;
use App\Services\Basket\BasketService;
use App\Http\Controllers\Controller;

class BasketController extends Controller
{
    protected $authService , $basketService;

    public function __construct(AuthService  $authService , BasketService $basketService)
    {
        $this->authService = $authService ;
        $this->basketService = $basketService ;
    }

    public  function append(BasktableInterface $model , BasketStore $request)
    {
        $user = $this->authService->user()  ;
        $unit = $request->input("unit") ;

        $basket =
            $this->basketService
                ->basket($request , $user)
                ->appendItem($model , $unit )
                ->get();

        return new BasketResource($basket) ;
    }
}
