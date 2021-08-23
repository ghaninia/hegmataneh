<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Repositories\Permission\PermissionRepository;

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
