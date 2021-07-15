<?php

namespace Database\Factories;

use App\Models\Role;
use App\Core\Enums\EnumsRole;
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

        $permissions = collect($roles = EnumsRole::all())->shuffle()->take(
            random_int(1, count($roles) - 1)
        )->toArray();

        return [
            "name" => $this->faker->company(),
            "permissions" => $permissions
        ];
    }
}
