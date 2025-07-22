<?php

namespace Database\Seeders;

use App\Models\Subscribe;
use App\Models\User;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call([
            RolesSeeder::class,
            PermissionsSeeder::class,
            UserSeeder::class,
            CategoriesSeeder::class,
            PostsSeeder::class,
            CommentsSeeder::class,
            LikePostSeeder::class,
            LikeCommentSeeder::class,
            SubscribesSeeder::class,
        ]);

    }
}
