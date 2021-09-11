<?php

namespace Database\Factories;

use App\Models\Serial;
use Illuminate\Database\Eloquent\Factories\Factory;

class SerialFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Serial::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "title" => $this->faker->realText(),
            "description" => $this->faker->realText()
        ];
    }
}
