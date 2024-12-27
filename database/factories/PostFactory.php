<?php

namespace Database\Factories;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;


class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $imageFiles = Storage::files('public/postImages');
        $randomImage = $imageFiles[array_rand($imageFiles)];

        $fileName = basename($randomImage);

        return [
            'title' => $this->faker->sentence(),
            'description' => $this->faker->paragraph(15, true),
            'image' => $fileName,
            'category_id' => $this->faker->numberBetween(1, 10),
            'user_id' =>  User::inRandomOrder()->first()->id,
            'likes' => 0
            ];
    }
}
