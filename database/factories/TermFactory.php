<?php

namespace Database\Factories;

use App\Models\Term;
use Illuminate\Support\Arr;
use App\Kernel\Enums\EnumsTerm;
use Illuminate\Database\Eloquent\Factories\Factory;

class TermFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Term::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "type" => $type = Arr::random(EnumsTerm::type()),
            "color" => $type === EnumsTerm::TYPE_CATEGORY ? $this->faker->hexColor() : null,
            "created_at" => $this->faker->dateTimeBetween($startDate = '-1 years', $endDate = 'now')->format("Y-m-d H:i:s")
        ];
    }
}
