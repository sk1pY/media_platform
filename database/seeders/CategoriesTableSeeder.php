<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $arr = ['Мемы','Новости','Игры','Музыка'];
        for ($i = 0; $i < count($arr); $i++) {
            Category::create([
                'name' => $arr[$i]
            ]);
        }
    }
}
