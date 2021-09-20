<?php

use Illuminate\Support\Facades\Route;
use App\Http\Resources\Translation\TranslationCollection;

Route::group([
    "as" => "guest.",
], function () {
    Route::view("/", "welcome")->name("main");
});


Route::get("test" , function(\Illuminate\Http\Request  $request){

    $product = \App\Models\Post::products()->first() ;

    $user =  \App\Models\User::first() ;

    $basket = app(\App\Services\Basket\BasketService::class)
        ->basket($request , $user)
        ->appendItem($product , 10 );

//    $basketable =  $user->basket->basketables()->first() ;
//
//    $basket = app(\App\Services\Basket\BasketService::class)
//        ->basket($request , $user)
//        ->deleteItem($basketable);

    return $basket->load("basketables") ;
});
