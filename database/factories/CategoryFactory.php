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

        return [
            'name' => $this->faker->unique()->randomElement($categories),
            'image' => $fileName,
        ];
    }
}
