<?php

namespace Database\Factories;

use App\Models\PostSerial;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostSerialFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PostSerial::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "title" => $this->faker->title(),
            "is_locked" => $this->faker->boolean(),
            "priority" => $this->faker->numerify("#"),
            "description" => $this->faker->realText()
        ];
    }
}
