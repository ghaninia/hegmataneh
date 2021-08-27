<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Artisan::call("passport:install") ;
        $this->call([
            PermissionSeeder::class,
            UserSeeder::class,
            OptionSeeder::class,
            TermSeeder::class
        ]);
    }
}
