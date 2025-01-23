<?php

namespace Database\Factories;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\File;
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
        $sourcePath = database_path('seeders/postImages');
        $destinationPath = storage_path('app/public/postImages');

        if (!File::exists($destinationPath)) {
            File::makeDirectory($destinationPath, 0755, true);
        }

        $files = File::files($sourcePath);


        foreach ($files as $file) {
            $destination = $destinationPath . '/' . basename($file);
            File::copy($file->getPathname(), $destination);
        }

        return [
            'title' => $this->faker->sentence(),
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
