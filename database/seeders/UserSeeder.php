<?php

namespace Database\Seeders;

use App\Models\Currency;
use App\Models\File;
use App\Models\Language;
use App\Models\Post;
use App\Models\Role;
use App\Models\User;
use App\Models\View;
use App\Models\Vote;
use App\Models\Skill;
use App\Models\Portfolio;
use App\Models\Permission;
use App\Kernel\Enums\EnumsOption;
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
                    ->state([
                        "email" => "info@ghaninia.ir"
                    ])
                    ->for(Language::factory()->create())
                    ->for(Currency::factory()->create())
                    ->has(
                        Portfolio::factory()
                    )
                    ->afterCreating(function ($user) {

                        // File::factory()
                        //     ->for($user)
                        //     ->state([
                        //         "id",
                        //         "file_id",
                        //         "user_id",
                        //         "type",
                        //         "name",
                        //         "extension",
                        //         "mime_type",
                        //         "size",
                        //     ])
                        //     ->create();

                        // app(FileServiceInterface::class)
                        //     ->setUser($user)
                        //     ->upload(
                        //         File
                        //     )

                        Post::factory()
                            ->for($user)
                            ->has(
                                View::factory()
                                    ->for($user)
                                    ->count(100)
                            )
                            ->count(100)
                            ->create();
                    })
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
