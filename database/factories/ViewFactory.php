<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\View;
use App\Models\Portfolio;
use Illuminate\Support\Arr;
use Illuminate\Database\Eloquent\Factories\Factory;

class ViewFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = View::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        $class = Arr::random([
            // Post::class,
            Portfolio::class
        ]);
        $class = $class::inRandomOrder()->first() ;
        return [
            "viewable_id" => $class->id,
            "viewable_type" => $class->getMorphClass(),
            "user_ip" => $this->faker->ipv4(),
            "marked" => $this->faker->boolean() ,
            "created_at" => $this->faker->dateTimeBetween($startDate = '-1 years', $endDate = 'now')
        ];
    }
}
