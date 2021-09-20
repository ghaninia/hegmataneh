<?php

namespace App\Http\Controllers\Api\Basket;

use App\Core\Interfaces\BasktableInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\Basket\BasketStore;
use App\Http\Resources\Basket\BasketResource;
use App\Services\Authunticate\AuthService;
use App\Services\Basket\BasketService;
use Illuminate\Support\Facades\Auth;

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
                ->appendItem($model , $unit );

        return $basket->load("basketables");

//        return new BasketResource() ;
    }
}
