<?php

namespace App\Http\Controllers\Dashboard\Basket;

use App\Http\Resources\Basket\BasketResource;
use App\Kernel\Basket\Interfaces\BasktableInterface;
use App\Http\Requests\Basket\BasketStore;
use App\Services\Authunticate\AuthServiceInterface;
use App\Http\Controllers\Controller;
use App\Services\Basket\BasketServiceInterface;

class BasketController extends Controller
{
    public function __construct(
        protected  AuthServiceInterface  $authService ,
        protected  BasketServiceInterface $basketService
    ){}

    /**
     * @param BasktableInterface $model
     * @param BasketStore $request
     * @return BasketResource
     */
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
