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
        $post = Post::inRandomOrder()->first() ;
        return [
            'user_ip' => $this->faker->ipv4(),
            'post_id' => $post->id ,
            'vote' => $this->faker->numberBetween(1,5) ,
            "created_at" => $this->faker->dateTimeBetween($startDate = '-1 years', $endDate = 'now')
        ];
    }
}
