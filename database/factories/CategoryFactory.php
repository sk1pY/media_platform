<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $imageFiles = Storage::files('public/categoryImages');
        $randomImage = $imageFiles[array_rand($imageFiles)];

        $fileName = basename($randomImage);
        return [
            'name' => $this->faker->lexify(str_repeat('?', rand(7, 10))),
            'image' => $fileName,
        ];
    }
}
