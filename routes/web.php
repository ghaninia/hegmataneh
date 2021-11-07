<?php

use App\Models\User;
use App\Core\Classes\UploadBuilder;
use Illuminate\Support\Facades\Route;
use App\Services\Widget\WidgetService;

Route::group([
    "as" => "guest.",
], function () {
    Route::view("/", "welcome")->name("main");
});

Route::get("test", function () {

    $user = User::first();
    $upload = new UploadBuilder($user);
    $upload->newFolder("salam wordpress", "941b28e2-cb0d-40f7-9e17-b98a36cfe45e");
});
