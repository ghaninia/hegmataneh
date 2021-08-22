<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use App\Core\Enums\EnumsUser;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            "mobile" => $this->faker->unique()->numerify("0911#######"),
            'status' => Arr::random(EnumsUser::status()),
            'email' => $this->faker->unique()->safeEmail(),
            "username" => $this->faker->unique()->userName(),
            'password' => bcrypt("secret"),
            "remember_token" => Str::random(10),
            "bio" => $this->faker->realText(1000)
        ];
    }
}
