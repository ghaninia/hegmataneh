<?php

namespace Tests\Configuration\Traits;

use Database\Seeders\DatabaseSeeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Artisan;

trait DatabaseRefreshOnlyOnce
{
    private static $databaseRefreshTurnOn = false;
    protected function setUpTraits()
    {
        parent::setUpTraits();
        // if (!self::$databaseRefreshTurnOn) {
        //     Artisan::call("migrate:fresh");
        //     $this->seed(DatabaseSeeder::class);
        //     self::$databaseRefreshTurnOn = true;
        // }
    }
}
