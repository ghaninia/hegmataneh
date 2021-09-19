<?php

use App\Http\Resources\Category\CategoryCollection;
use App\Http\Resources\Translation\TranslationCollection;
use App\Models\Term;
use Illuminate\Support\Facades\Route;

Route::group([
    "as" => "guest.",
], function () {
    Route::view("/", "welcome")->name("main");
});


Route::get("test" , function(){

    $terms = Term::with("translations")->get() ;

    return new CategoryCollection($terms) ;
});
