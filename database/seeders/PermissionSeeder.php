<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
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
        $actions = array_map(
            fn ($action) => ["action" => $action],
            getEntireRoutesAction()
        );
        app(PermissionRepository::class)->createMultiple(
            $actions
        );
    }
}
