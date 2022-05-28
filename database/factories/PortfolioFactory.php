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
            "demo" => $this->faker->url,
            "percent" => $this->faker->numberBetween(0, 100),
            "launched_at" => $this->faker->dateTimeBetween($startDate = '-1 years', $endDate = 'now')->format("Y-m-d H:i:s")
        ];
    }
}
