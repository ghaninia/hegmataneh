<?php

namespace Database\Seeders;

use App\Core\Enums\EnumsOption;
use App\Models\Permission;
use App\Models\Portfolio;
use App\Models\Post;
use App\Models\Role;
use App\Models\Skill;
use App\Models\User;
use App\Models\View;
use App\Models\Vote;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::factory()
            ->has(
                User::factory()
                    ->has(
                        Portfolio::factory()
                    )
                    // ->has(
                    //     Post::factory()
                    // )
                    // ->has(
                    //     View::factory()
                    // )
                    // ->has(
                    //     Vote::factory()
                    // )
                    // ->has(
                    //     Skill::factory()
                    // )
            )
            ->create();
    }
}
