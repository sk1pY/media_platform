<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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
        $sourcePath = database_path('seeders/categoryImages');
        $destinationPath = storage_path('app/public/categoryImages');

        if (!File::exists($destinationPath)) {
            File::makeDirectory($destinationPath, 0755, true);
        }

        $files = File::files($sourcePath);


        foreach ($files as $file) {
            $destination = $destinationPath . '/' . basename($file);
            File::copy($file->getPathname(), $destination);
        }

        $categories = [
            "Технологии",
            "Наука",
            "Образование",
            "Финансы",
            "Бизнес",
            "Искусство",
            "Музыка",
            "Кино",
            "Книги",
            "Здоровье",
            "Медицина",
            "Спорт",
            "Фитнес",
            "Путешествия",
            "Туризм",
            "Кулинария",
            "Рецепты",
            "Домашний уют",
            "Дизайн интерьера",
            "Садоводство",
            "Автомобили",
            "Мотоциклы",
            "Мода",
            "Красота",
            "Строительство",
            "Архитектура",
            "История",
            "Культура",
            "Политика",
            "Экология"
        ];
        $name = $this->faker->unique()->randomElement($categories);
        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'image' => $files ? $files[array_rand($files)]->getFilename() : null,
        ];
    }
}
