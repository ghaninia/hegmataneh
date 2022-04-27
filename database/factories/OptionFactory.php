<?php

namespace Database\Factories;

use App\Kernel\Enums\EnumsOption;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Option>
 */
class OptionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "key" => $this->faker->unique()->slug() ,
            "type" => Arr::random(EnumsOption::type()),
            "default" => $this->faker->unique()->slug() ,
            "value" => $this->faker->numerify()
        ];
    }
}
