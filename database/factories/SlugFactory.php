<?php

namespace Database\Factories;

use App\Models\Slug;
use Illuminate\Database\Eloquent\Factories\Factory;

class SlugFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Slug::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "slug" => $this->faker->unique()->slug()
        ];
    }
}
