<?php

namespace Database\Factories;

use App\Models\Portfolio;
use Illuminate\Database\Eloquent\Factories\Factory;

class PortfolioFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Portfolio::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "name" => $this->faker->company() ,
            "description" => $this->faker->realText(100) ,
            "demo" => $this->faker->url ,
            "excerpt" => $this->faker->realText(300),
            "percent" => $this->faker->numberBetween(0,100),
            "started_at" => $this->faker->dateTimeBetween($startDate = '-1 years', $endDate = 'now')
        ];
    }
}
