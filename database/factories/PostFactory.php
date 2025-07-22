<?php

namespace Database\Factories;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $files = File::files(database_path('seeders/postImages'));

        $title = $this->faker->sentence(5);
        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'short_description' => $this->faker->text(30),
            'description' => $this->faker->paragraph(15, true),
            'image' => $files ? $files[array_rand($files)]->getFilename() : null,
            'category_id' => $this->faker->numberBetween(1, 10),
            'user_id' =>  User::inRandomOrder()->first()->id,
            'likes' => 0,
            'views' => $this->faker->numberBetween(0, 50),
            'status' => 1,
            ];
    }
}
