<?php

namespace Tests\Dependency\Traits;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Artisan;
use Database\Seeders\RefreshDatabase\RefreshDatabaseSeeder;

trait FreshSeedOnce
{
    /**
     * If true, setup has run at least once.
     * @var boolean
     */
    // protected static $setUpHasRunOnce = false;
    /**
     * After the first run of setUp "migrate:fresh --seed"
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $seeders = [
            "passport:install",
            "cache:clear"
        ];
        array_walk($seeders, function ($seed) {
            Artisan::call($seed);
        });
    }
}
