<?php

namespace Database\Factories;

use App\Models\Language;
use Illuminate\Support\Arr;
use App\Core\Enums\EnumsLanguage;
use Illuminate\Database\Eloquent\Factories\Factory;

class LanguageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Language::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "code" => $code = $this->faker->unique()->languageCode(),
            "name" => $code,
            "direction" => Arr::random(EnumsLanguage::direction())
        ];
    }
}
