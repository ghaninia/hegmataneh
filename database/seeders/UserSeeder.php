<?php

namespace Database\Seeders;

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
        Role::factory()->has(
            User::factory()
                ->has(
                    Portfolio::factory()->count(10)
                )
                ->has(
                    Post::factory()->count(10)
                )
                ->has(
                    View::factory()->count(10)
                )
                ->has(
                    Vote::factory()->count(10)
                )
                ->has(
                    Skill::factory()->count(5)
                )
                ->count(10)
        )
        ->count(5)
        ->create();
    }
}
