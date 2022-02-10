<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::insert($actions = array_map(
            fn ($action) => ["action" => $action],
            getEntireRoutesAction()
        ));
    }
}
