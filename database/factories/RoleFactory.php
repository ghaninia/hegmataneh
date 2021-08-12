<?php

namespace Database\Factories;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Database\Eloquent\Factories\Factory;

class RoleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Role::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "name" => $this->faker->company(),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Role $role) {
            $permissions =
                Permission::inRandomOrder()
                ->take(
                    random_int(1, count(getEntireRoutesAction()))
                )
                ->pluck("id")
                ->toArray();

            $role->permissions()->attach($permissions);
        });
    }
}
