<?php

namespace Database\Factories;

use Carbon\Carbon;
use App\Models\Post;
use Illuminate\Support\Arr;
use App\Kernel\Enums\EnumsPost;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Post::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "status" => Arr::random(EnumsPost::status()),
            "type" => $type = Arr::random(EnumsPost::type()) ,
            "comment_status" => $this->faker->boolean() ,
            "vote_status" => $this->faker->boolean() ,
            "format" => $format = Arr::random(EnumsPost::format()),
            "development" => $this->faker->numberBetween(0,100),
            "published_at" => $this->faker->dateTime() ,
            "created_at" => Carbon::parse($this->faker->dateTimeBetween())
        ];
    }
}
