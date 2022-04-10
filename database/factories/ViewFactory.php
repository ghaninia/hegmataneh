<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\View;
use App\Models\Portfolio;
use Carbon\Carbon;
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
        return [
            "ipv4" => $this->faker->ipv4(),
            "created_at" => $this->faker->dateTimeBetween()
        ];
    }
}
