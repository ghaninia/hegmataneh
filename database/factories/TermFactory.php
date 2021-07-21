<?php

namespace Database\Factories;

use App\Models\Term;
use Illuminate\Support\Arr;
use App\Core\Enums\EnumsTerm;
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
            "slug" => $this->faker->unique()->slug() ,
            "color" => $type === EnumsTerm::TYPE_CATEGORY ? $this->faker->hexColor() : null ,
            "name" => $this->faker->company() ,
            "description" => $this->faker->realText(100),
            "created_at" => $this->faker->dateTimeBetween($startDate = '-1 years', $endDate = 'now')
        ];
    }
}
