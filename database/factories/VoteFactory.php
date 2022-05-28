<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\Vote;
use Illuminate\Database\Eloquent\Factories\Factory;

class VoteFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Vote::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'ipv4' => $this->faker->ipv4(),
            'vote' => $this->faker->numberBetween(1, 5),
            "created_at" => $this->faker->dateTimeBetween($startDate = '-1 years', $endDate = 'now')->format("Y-m-d H:i:s")
        ];
    }
}
