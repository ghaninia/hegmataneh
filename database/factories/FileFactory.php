<?php

namespace Database\Factories;

use App\Kernel\Enums\EnumsFile;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\File>
 */
class FileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "type" => Arr::random(EnumsFile::type()),
            "name" => $this->faker->realText(20),
            "relpath" => $this->faker->filePath(),
            "extension" => $this->faker->fileExtension(),
            "mime_type" => $this->faker->mimeType(),
            "size" => $this->faker->numerify(),
        ];
    }
}
